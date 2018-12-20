<?php

namespace App\Services;

use Carbon\Carbon;
use App, Log, DB;
use App\Models\Order;

;

use App\Models\Product;


class ApiService
{
    public static function getGeneralInformation()
    {
        //days
        $startDay = new Carbon(CommonService::getSettingChosenValue('START_DATE'));
        $diffInSeconds = (new Carbon($startDay))->diffInSeconds(Carbon::now());
        $days = ceil($diffInSeconds / (24 * 3600));

        //product value
        $productValue = 0;
        $products = Product::where('status', Product::STATUS['IN_BUSINESS'])->get();
        foreach ($products as $product) {
            $productValue += ($product->getAvailableQuantity() * $product->getAVGValue());
        }
        $productValue = ceil($productValue / 1000);

        //profit
        $profit = ceil(Order::join('order_details', 'orders.id', 'order_details.order_id')
                ->whereIn('orders.status', [Order::STATUS['PAID'], Order::STATUS['INTERNAL']])
                ->sum('order_details.price') / 1000);

        //today data
        $todayData = CommonService::getOrderProfitByDay(Carbon::now());

        //yesterday data
        $yesterdayData = CommonService::getOrderProfitByDay(Carbon::now()->subDay(1));

        //percentage increase
        $percentageIncrease = $todayData['profit'] < $yesterdayData['profit'] ? ceil($todayData['profit'] / $yesterdayData['profit'] * 100) : 100;

        return [
            'days' => $days,
            'productValue' => $productValue,
            'profit' => $profit,
            'todayData' => $todayData,
            'yesterdayData' => $yesterdayData,
            'percentageIncrease' => $percentageIncrease
        ];
    }
}