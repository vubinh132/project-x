<?php

namespace App\Services;

use Carbon\Carbon;
use App, Log, DB;
use GuzzleHttp\Client;
use App\Models\Order;
use Exception;
use App\Models\Product;
use App\Services\CommonService;
use App\SDKs\lazada\lazop\LazopClient;
use App\SDKs\lazada\lazop\LazopRequest;
use App\SDKs\lazada\lazop\UrlConstants;


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

    const MODE = [
        'STATUS_AND_TIME' => 1,
        'ALL' => 2,
    ];

    public static function syncOrders($startDay, $endDay, $mode = 1)
    {
        try {

            //get token

            $token = CommonService::getSettingChosenValue("L_TOKEN");

            $update = 0;

            $insert = 0;

            $fail = 0;

            $MProducts = Product::where('status', Product::STATUS['IN_BUSINESS'])->get()->pluck('sku')->toArray();

            $updateAfter = (new Carbon($startDay))->startOfDay()->toIso8601String();

            $updateBefore = (new Carbon($endDay))->endOfDay()->toIso8601String();

            $c = new LazopClient(UrlConstants::$api_gateway_url_vn, config('lazada.APP_KEY'), config('lazada.APP_SECRET'));

            $r = new LazopRequest('/orders/get', 'GET');

            $r->addApiParam('update_after', $updateAfter);

            $r->addApiParam('update_before', $updateBefore);

            $r->addApiParam('sort_by', 'updated_at');

            $r->addApiParam('sort_direction', 'ASC');

            $res = $c->execute($r, $token);

            $body = json_decode($res, true);

            if ($body['code'] == 0) {
                $orders = Order::where('selling_web', Order::SELLING_WEB['LAZADA'])->get();
                $lazadaOrders = $body['data']['orders'];
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
                    $LStatus = LazadaService::ORDER_STATUS[$lazadaOrder['statuses'][0]];

                    //lazada order details
                    $LProductsRes = LazadaService::getOrderItems($lazadaOrderCode);

                    if (!$LProductsRes['success']) {
                        $fail++;
                        continue;
                    }

                    $LProducts = LazadaService::formatOrders($LProductsRes['data'], $MProducts);

                    if (!$LProducts['success']) {
                        $fail++;
                        continue;
                    }
                    $LProducts = $LProducts['data'];

                    $flag = false;

                    foreach ($orders as $order) {
                        $orderCode = explode('L-', $order->code)[1];
                        if ($lazadaOrderCode == $orderCode) {
                            $flag = true;
                            //update order information
                            if ($mode == LazadaService::MODE['STATUS_AND_TIME']) {
                                $order->update([
                                    'status' => $LStatus,
                                    'api_updated_at' => $LUpdatedAt
                                ]);
                                $update++;
                            } else {
                                $order->update([
                                    'name' => $LName,
                                    'phone' => $LPhone,
                                    'address' => $LAddress,
                                    'status' => $LStatus,
                                    'api_created_at' => new Carbon($LCreatedAt),
                                    'api_updated_at' => new Carbon($LUpdatedAt),
                                ]);
                                //check order details
                                foreach ($LProducts as $product) {
                                    $LSku = $product[0];
                                    $LQuantity = $product[1];
                                    $LPrice = $product[2];

                                    $p = Product::select('order_details.*')
                                        ->join('order_details', 'order_details.product_id', 'products.id')
                                        ->join('orders', 'orders.id', 'order_details.order_id')
                                        ->where('orders.code', 'like', "L-$lazadaOrderCode%")
                                        ->where('products.sku', 'like', $LSku)
                                        ->first();

                                    if ($p) {
                                        //update order detail

                                    } else {
                                        //if order details doesn't exist
                                    }

                                }
                                $update++;
                            }

                            break;
                        }
                    }
                    if (!$flag) {

                        try {

                            DB::transaction(function () use ($lazadaOrderCode, $LName, $LPhone, $LAddress, $LStatus, $LCreatedAt, $LUpdatedAt, $LProducts) {

                                $order = Order::create([
                                    'code' => "L-$lazadaOrderCode",
                                    'name' => $LName,
                                    'phone' => $LPhone,
                                    'address' => $LAddress,
                                    'status' => $LStatus,
                                    'selling_web' => 2,
                                    'api_created_at' => new Carbon($LCreatedAt),
                                    'api_updated_at' => new Carbon($LUpdatedAt)
                                ]);
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
            }
            $errorRes = $body['ErrorResponse'];
            return [
                'success' => false,
                'message' => $errorRes['Head']['ErrorMessage']
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function syncOrderByDay($day)
    {
        $res = LazadaService::syncOrders($day, $day, LazadaService::MODE['ALL']);
        $success = $res['success'];
        if ($success) {
            $insert = $res['data']['insert'];
            $update = $res['data']['update'];
            $fail = $res['data']['fail'];
            return [
                'success' => true,
                'data' => [
                    'insert' => $insert,
                    'update' => $update,
                    'fail' => $fail,
                ]
            ];
        } else {
            $message = $res['message'];
            $mess = "Sync orders from Lazada is failed. $message";
            return [
                'success' => false,
                'message' => $mess
            ];
        }

    }

    private static function getOrderItems($code)
    {
        try {

            $token = CommonService::getSettingChosenValue("L_TOKEN");

            $c = new LazopClient(UrlConstants::$api_gateway_url_vn, config('lazada.APP_KEY'), config('lazada.APP_SECRET'));

            $r = new LazopRequest('/order/items/get', 'GET');

            $r->addApiParam('order_id', $code);

            $res = $c->execute($r, $token);

            $body = json_decode($res, true);

            if ($body['code'] == 0) {
                return [
                    'success' => true,
                    'data' => $body['data']
                ];
            }
            $errorRes = $body['ErrorResponse'];
            return [
                'success' => false,
                'message' => $errorRes['Head']['ErrorMessage']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private static function createUrl($url, $parameters)
    {

        $staticParams = [
            'UserID' => config('lazada.USER_ID'),
            'Version' => config('lazada.API_VERSION'),
            'Format' => config('lazada.RETURN_FORMAT_DATA'),
        ];

        foreach ($staticParams as $key => $value) {
            $parameters[$key] = $value;
        }

        ksort($parameters);

        $encoded = array();

        $i = 0;
        foreach ($parameters as $name => $value) {
            $encodedData = rawurlencode($name) . '=' . rawurlencode($value);
            if ($i == 0) {

                $url = $url . '?' . $encodedData;
            } else {
                $url = $url . '&' . $encodedData;
            }
            $encoded[] = $encodedData;
            $i++;
        }

        $concatenated = implode('&', $encoded);

        $api_key = config('lazada.API_KEY');

        $signature = rawurlencode(hash_hmac('sha256', $concatenated, $api_key, false));

        $url = $url . '&Signature=' . $signature;

        return $url;
    }

    private static function formatOrders($rawOrders, $MProducts)
    {
        $result = [];

        foreach ($rawOrders as $rawOrder) {
            $sku = config('lazada.' . $rawOrder['sku'], $rawOrder['sku']);
            //package
            if (str_contains($sku, '&')) {
                $SKUs = explode('&', $sku);
                $numOfItem = count($SKUs);
                foreach ($SKUs as $SKU) {
                    //check sku
                    if (!in_array($SKU, $MProducts)) {
                        Log::info("======= wrong sku $SKU =======");
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
            } else {
                if (!in_array($sku, $MProducts)) {
                    Log::info("======= wrong sku $sku =======");
                    return [
                        'success' => false,
                        'message' => 'sku is wrong'
                    ];
                }
                $flag = false;
                for ($i = 0; $i < count($result); $i++) {
                    if ($result[$i][0] == $sku) {
                        $oldQuantity = $result[$i][1];
                        $oldPrice = $result[$i][2];
                        $result[$i] = [$sku, $oldQuantity + 1, $oldPrice + $rawOrder['item_price']];
                        $flag = true;
                        break;
                    }
                }
                if (!$flag) {
                    $result[] = [$sku, 1, $rawOrder['item_price']];
                }
            }
        }

        return [
            'success' => true,
            'data' => $result
        ];
    }
}