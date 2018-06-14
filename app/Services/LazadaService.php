<?php

namespace App\Services;

use Carbon\Carbon;
use App, Log, DB;
use GuzzleHttp\Client;
use App\Models\Order;
use Exception;
use App\Models\Product;


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

    public static function syncOrders($day, $mode = 1)
    {
        try {

            $update = 0;

            $insert = 0;

            $fail = 0;

            $MProducts = Product::where('status', Product::STATUS['IN_BUSINESS'])->get()->pluck('sku')->toArray();

            $now = Carbon::now()->toIso8601String();

            $updateAfter = Carbon::now()->subDay($day)->toIso8601String();

            $url = config('lazada.ROOT_URL');

            $parameters = array(

                // The API method to call.
                'Action' => 'GetOrders',

                // The current time in ISO8601 format
                'Timestamp' => $now,

                'UpdatedAfter' => $updateAfter,

                'SortBy' => 'updated_at',

                'SortDirection' => 'ASC'
            );

            $url = LazadaService::createUrl($url, $parameters);

            $client = new Client();

            $res = $client->request('GET', $url);

            $body = json_decode($res->getBody()->getContents(), true);

            if (isset($body['SuccessResponse'])) {
                $successRes = $body['SuccessResponse'];
                $orders = Order::where('selling_web', Order::SELLING_WEB['LAZADA'])->get();
                $lazadaOrders = $successRes['Body']['Orders'];
                foreach ($lazadaOrders as $lazadaOrder) {

                    //lazada order information
                    $lazadaOrderCode = sprintf('%.0f', $lazadaOrder['OrderNumber']);
                    $LPhone = $lazadaOrder['AddressShipping']['Phone'];
                    $LName = $lazadaOrder['AddressShipping']['FirstName'];
                    $LAddress = $lazadaOrder['AddressShipping']['Address1'] . ' ,'
                        . $lazadaOrder['AddressShipping']['Address5'] . ' ,'
                        . $lazadaOrder['AddressShipping']['Address4'] . ' ,'
                        . $lazadaOrder['AddressShipping']['Address3'] . ' ,'
                        . $lazadaOrder['AddressShipping']['Country'];
                    $LCreatedAt = $lazadaOrder['CreatedAt'];
                    $LUpdatedAt = $lazadaOrder['UpdatedAt'];
                    $LStatus = LazadaService::ORDER_STATUS[$lazadaOrder['Statuses'][0]];

                    //lazada order details
                    $LProductsRes = LazadaService::getOrderItem($lazadaOrderCode);

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
                                    'api_created_at' => $LCreatedAt,
                                    'api_updated_at' => $LUpdatedAt,
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
                                    'api_created_at' => $LCreatedAt,
                                    'api_updated_at' => $LUpdatedAt
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

    public static function syncAllOrders()
    {
        $step = 30;

        $startDay = new Carbon(CommonService::getSettingChosenValue('START_DATE'));

        $result = [];

        $days = $startDay->diffInDays(Carbon::now());
        while ($days > 0) {

            $res = LazadaService::syncOrders($days, 2);

            $result[] = $res;

            $days -= $step;
        }

        return $result;
    }

    private static function getOrderItem($code)
    {
        try {
            $now = Carbon::now()->toIso8601String();

            $url = config('lazada.ROOT_URL');

            $parameters = array(

                // The API method to call.
                'Action' => 'GetOrderItems',

                // The current time in ISO8601 format
                'Timestamp' => $now,

                'OrderId' => $code

            );

            $url = LazadaService::createUrl($url, $parameters);

            $client = new Client();

            $res = $client->request('GET', $url);

            $body = json_decode($res->getBody()->getContents(), true);

            if (isset($body['SuccessResponse'])) {
                $successRes = $body['SuccessResponse'];
                return [
                    'success' => true,
                    'data' => $successRes['Body']['OrderItems']
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
            $sku = config('lazada.' . $rawOrder['Sku'], $rawOrder['Sku']);
            //package
            if (str_contains($sku, '&')) {
                $SKUs = explode('&', $sku);
                $numOfItem = count($SKUs);
                foreach ($SKUs as $SKU) {
                    //check sku
                    if (!in_array($SKU, $MProducts)) {
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
                            $result[$i] = [$SKU, $oldQuantity + 1, $oldPrice + $rawOrder['ItemPrice'] / $numOfItem];
                            $flag = true;
                            break;
                        }
                    }
                    if (!$flag) {
                        $result[] = [$SKU, 1, $rawOrder['ItemPrice'] / $numOfItem];
                    }
                }
            } else {
                if (!in_array($sku, $MProducts)) {
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
                        $result[$i] = [$sku, $oldQuantity + 1, $oldPrice + $rawOrder['ItemPrice']];
                        $flag = true;
                        break;
                    }
                }
                if (!$flag) {
                    $result[] = [$sku, 1, $rawOrder['ItemPrice']];
                }
            }
        }

        return [
            'success' => true,
            'data' => $result
        ];
    }
}