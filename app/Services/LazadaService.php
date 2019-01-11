<?php

namespace App\Services;

use Carbon\Carbon;
use App, Log, DB;
use App\Models\Order;
use Exception;
use App\Models\Product;
use App\SDKs\lazada\lazop\LazopClient;
use App\SDKs\lazada\lazop\LazopRequest;
use App\SDKs\lazada\lazop\UrlConstants;
use App\Models\ShopProduct;


class LazadaService
{
    const ORDER_STATUS = [
        'pending' => 1,
        'shipped' => 1,
        'ready_to_ship' => 1,
        'delivered' => 2,
        'returned' => 5,
        'canceled' => 4,
        'failed' => 5
    ];


    //order APIs
    public static function syncOrders($startDay, $endDay)
    {
        try {
            $update = 0;
            $insert = 0;
            $fail = 0;

            $orders = Order::where('selling_web', Order::SELLING_WEB['LAZADA'])->get();

            $params = [
                'update_after' => (new Carbon($startDay))->startOfDay()->toIso8601String(),
                'update_before' => (new Carbon($endDay))->endOfDay()->toIso8601String(),
                'sort_by' => 'updated_at',
                'sort_direction' => 'DESC'
            ];

            $res = LazadaService::callAPI('GET', '/orders/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $lazadaOrders = $res['data']['orders'];

            foreach ($lazadaOrders as $lazadaOrder) {
                //lazada order information
                $lazadaOrderCode = sprintf('%.0f', $lazadaOrder['order_number']);
                $LPhone = $lazadaOrder['address_shipping']['phone'];
                $LName = $lazadaOrder['address_shipping']['first_name'];
                $LAddress = $lazadaOrder['address_shipping']['address1'] . ' ,'
                    . $lazadaOrder['address_shipping']['address5'] . ' ,'
                    . $lazadaOrder['address_shipping']['address4'] . ' ,'
                    . $lazadaOrder['address_shipping']['address3'] . ' ,'
                    . $lazadaOrder['address_shipping']['country'];
                $LCreatedAt = $lazadaOrder['created_at'];
                $LUpdatedAt = $lazadaOrder['updated_at'];
                $LStatuses = $lazadaOrder['statuses'];

                $flag = false;

                foreach ($orders as $order) {

                    $orderCode = explode('L-', $order->code)[1];

                    if ($lazadaOrderCode == $orderCode) {
                        $flag = true;
                        //update order information
                        $numOfStatus = count($LStatuses);

                        if ($numOfStatus == 1) {
                            $order->update([
                                'status' => LazadaService::ORDER_STATUS[$LStatuses[0]],
                                'api_updated_at' => new Carbon($LUpdatedAt)
                            ]);
                        } else {
                            $order->update([
                                'is_parted' => true,
                                'status' => LazadaService::ORDER_STATUS[$LStatuses[1]],
                                'api_updated_at' => new Carbon($LUpdatedAt),
                            ]);
                            Log::info("$lazadaOrderCode - $numOfStatus - " . LazadaService::ORDER_STATUS[$LStatuses[1]]);
                        }

                        $update++;
                        break;
                    }
                }
                if (!$flag) {
                    //lazada order details
                    $productsRes = LazadaService::getOrderProducts($lazadaOrderCode);
                    if (!$productsRes['success']) {
                        $fail++;
                        continue;
                    }

                    $LProducts = $productsRes['data'];

                    try {

                        DB::transaction(function () use ($lazadaOrderCode, $LName, $LPhone, $LAddress, $LCreatedAt, $LUpdatedAt, $LProducts, $LStatuses) {

                            $numOfStatus = count($LStatuses);

                            if ($numOfStatus == 1) {
                                $order = Order::create([
                                    'code' => "L-$lazadaOrderCode",
                                    'name' => $LName,
                                    'phone' => $LPhone,
                                    'address' => $LAddress,
                                    'status' => LazadaService::ORDER_STATUS[$LStatuses[0]],
                                    'selling_web' => 2,
                                    'api_created_at' => new Carbon($LCreatedAt),
                                    'api_updated_at' => new Carbon($LUpdatedAt)
                                ]);
                            } else {
                                $order = Order::create([
                                    'is_parted' => true,
                                    'code' => "L-$lazadaOrderCode",
                                    'name' => $LName,
                                    'phone' => $LPhone,
                                    'address' => $LAddress,
                                    'status' => LazadaService::ORDER_STATUS[$LStatuses[1]],
                                    'selling_web' => 2,
                                    'api_created_at' => new Carbon($LCreatedAt),
                                    'api_updated_at' => new Carbon($LUpdatedAt)
                                ]);
                            }
                            foreach ($LProducts as $LProduct) {
                                $product = Product::where('sku', $LProduct[0])->firstOrFail();
                                $order->products()->attach($product, ['quantity' => -$LProduct[1], 'price' => $LProduct[2]]);
                            }
                        });

                        $insert++;

                    } catch (Exception $e) {
                        $fail++;
                    }
                }
            }
            return [
                'success' => true,
                'data' => [
                    'insert' => $insert,
                    'update' => $update,
                    'fail' => $fail
                ]
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private static function getOrderProducts($orderId)
    {
        try {
            $result = [];

            $MProducts = Product::where('status', Product::STATUS['IN_BUSINESS'])->get()->pluck('sku')->toArray();

            $res = LazadaService::callAPI('GET', '/order/items/get', ['order_id' => $orderId]);
            if (!$res['success']) {
                return $res;
            }
            $rawOrders = $res['data'];

            //format orders
            foreach ($rawOrders as $rawOrder) {
                $sku = config('lazada.' . $rawOrder['sku'], $rawOrder['sku']);
                //package
                if (str_contains($sku, '&') && $sku != 'BNU02-S&M') {
                    $SKUs = explode('&', $sku);
                } else {
                    $SKUs = [$sku];
                }

                $numOfItem = count($SKUs);

                foreach ($SKUs as $SKU) {
                    //check sku
                    if (!in_array($SKU, $MProducts)) {
                        Log::error("======= wrong sku $SKU =======");
                        return [
                            'success' => false,
                            'data' => 'sku is wrong'
                        ];
                    }

                    $flag = false;

                    for ($i = 0; $i < count($result); $i++) {
                        if ($result[$i][0] == $SKU) {
                            $oldQuantity = $result[$i][1];
                            $oldPrice = $result[$i][2];
                            $result[$i] = [$SKU, $oldQuantity + 1, $oldPrice + $rawOrder['item_price'] / $numOfItem];
                            $flag = true;
                            break;
                        }
                    }
                    if (!$flag) {
                        $result[] = [$SKU, 1, $rawOrder['item_price'] / $numOfItem];
                    }
                }
            }

            return [
                'success' => true,
                'data' => $result
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    //products APIs
    public static function getProductQuantity()
    {
        try {
            $SKUs = [];

            // get live products
            $params = [
                'filter' => 'live',
                'limit' => 100
            ];

            $res = LazadaService::callAPI('GET', '/products/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $products = $res['data']['products'];
            foreach ($products as $product) {
                foreach ($product['skus'] as $sku) {
                    $SKUs[$sku['SellerSku']] = $sku['Available'];
                }
            }

            //get sold out products
            $params = [
                'filter' => 'sold-out',
                'limit' => 100
            ];

            $res = LazadaService::callAPI('GET', '/products/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $products = $res['data']['products'];
            foreach ($products as $product) {
                foreach ($product['skus'] as $sku) {
                    $SKUs[$sku['SellerSku']] = $sku['Available'];
                }
            }

            //sort array
            ksort($SKUs);

            return ['success' => true, 'products' => $SKUs];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function getProductSKUs()
    {
        try {
            $SKUs = [];

            // get live products
            $params = [
                'filter' => 'live',
                'limit' => 100
            ];

            $res = LazadaService::callAPI('GET', '/products/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $products = $res['data']['products'];
            foreach ($products as $product) {
                foreach ($product['skus'] as $sku) {
                    $SKUs[] = $sku['SellerSku'];
                }
            }

            //get sold out products
            $params = [
                'filter' => 'sold-out',
                'limit' => 100
            ];

            $res = LazadaService::callAPI('GET', '/products/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $products = $res['data']['products'];
            foreach ($products as $product) {
                foreach ($product['skus'] as $sku) {
                    $SKUs[] = $sku['SellerSku'];
                }
            }
            return [
                'success' => true,
                'data' => $SKUs
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function getQuantity($sku)
    {
        try {
            $params = [
                'filter' => 'all',
                'search' => $sku
            ];

            $res = LazadaService::callAPI('GET', '/products/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $data = $res['data'];
            if (!$data) {
                return [
                    'success' => false,
                    'message' => "SKU doesn't exist"
                ];
            }
            $quantityRes = [];
            foreach ($data['products'] as $product) {
                foreach ($product['skus'] as $SKU) {
                    $sellerSku = $SKU['SellerSku'];
                    if ($sellerSku == $sku) {
                        $quantityRes[$sellerSku] = $SKU['Available'];
                    }
                }
            }

            if (!$quantityRes) {
                return [
                    'success' => false,
                    'message' => "given SKU doesn't match"
                ];
            }


            return [
                'success' => true,
                'data' => [
                    'quantity' => $quantityRes[$sku]
                ]
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function setQuantity($sku, $quantity)
    {
        try {
            $params = [
                'payload' => "<Request><Product><Skus><Sku><SellerSku>$sku</SellerSku><Quantity>$quantity</Quantity><Price/><SalePrice/><SaleStartDate/><SaleEndDate/></Sku></Skus></Product></Request>"
            ];

            $res = LazadaService::callAPI('POST', '/product/price_quantity/update', $params);
            if (!$res['success']) {
                return $res;
            }
            return [
                'success' => true
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function syncProducts()
    {
        try {

            $insert = 0;
            $update = 0;
            $soldOut = 0;
            $delete = 0;

            $existedSKUs = ShopProduct::pluck('sku')->toArray();

            // get live products
            $params = [
                'filter' => 'live',
                'limit' => 100
            ];

            $res = LazadaService::callAPI('GET', '/products/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $products = $res['data']['products'];
            foreach ($products as $product) {
                foreach ($product['skus'] as $sku) {
                    if (LazadaService::updateSKUData($sku, $existedSKUs) == 'u') {
                        $existedSKUs = array_diff($existedSKUs, [$sku['SellerSku']]);
                        $update++;
                    } else {
                        $insert++;
                    }
                }
            }

            //get sold out products
            $params = [
                'filter' => 'sold-out',
                'limit' => 100
            ];
            $res = LazadaService::callAPI('GET', '/products/get', $params);
            if (!$res['success']) {
                return $res;
            }
            $products = $res['data']['products'];
            foreach ($products as $product) {
                foreach ($product['skus'] as $sku) {
                    if (LazadaService::updateSKUData($sku, $existedSKUs) == 'u') {
                        $existedSKUs = array_diff($existedSKUs, [$sku['SellerSku']]);
                        $update++;
                    } else {
                        $insert++;
                    }
                    $soldOut++;
                }
            }

            //delete sku
            $deleteSKUs = ShopProduct::whereIn('sku', $existedSKUs)->get();
            foreach ($deleteSKUs as $deleteSKUs) {
                $deleteSKUs->delete();
                $delete++;
            }

            return [
                'success' => true,
                'data' => [
                    'insert' => $insert,
                    'update' => $update,
                    'soldOut' => $soldOut,
                    'delete' => $delete
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    //return u if update and i if insert
    private static function updateSKUData($sku, $existedSKUs)
    {
        $productSKU = $sku['SellerSku'];
        $productAvailable = $sku['Available'];
        if (in_array($productSKU, $existedSKUs)) {
            $shopProduct = ShopProduct::where('sku', $productSKU)->first();
            if ($shopProduct) {
                $shopProduct->update(['lazada' => $productAvailable]);
            }
            return 'u';
        } else {
            ShopProduct::create(['sku' => $productSKU, 'lazada' => $productAvailable]);
            return 'i';
        }
    }

    //call API
    private static function callAPI($method, $url, $params)
    {
        try {

            $token = CommonService::getSettingChosenValue("L_TOKEN");

            $c = new LazopClient(UrlConstants::$api_gateway_url_vn, config('lazada.APP_KEY'), config('lazada.APP_SECRET'));

            $r = new LazopRequest($url, $method);

            foreach ($params as $key => $value) {

                $r->addApiParam($key, $value);
            }

            $res = $c->execute($r, $token);

            $body = json_decode($res, true);

            $code = $body['code'];

            if (!$code) {
                if (isset($body['data'])) {
                    return [
                        'success' => true,
                        'data' => $body['data']
                    ];
                } else {
                    return [
                        'success' => true,
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => $body['message']
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}