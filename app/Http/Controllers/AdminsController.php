<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CommonService;
use Carbon\Carbon;
use App\Models\Order;
use Log, DB, Mail;


class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()

    {
//        Mail::to('vuqbinh995@gmail.com')->send(new SimpleEmailSender('test', 'emails.template', ['content' => 'just test'], null));

        //start date
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
        $profit = ceil(Order::join('order_details', 'orders.id', 'order_details.order_id')->whereIn('orders.status', [Order::STATUS['PAID'], Order::STATUS['INTERNAL']])->sum('order_details.price') / 1000);


        //TODAY data
        $today = Carbon::now()->startOfDay();
        $todayProfit = 0;

        //if order have api_created_at, where by api_created_at. Else where by created_at
        $todayOrders = Order::whereIn('status', [Order::STATUS['ORDERED'], Order::STATUS['PAID']])
            ->where('orders.api_created_at', '>=', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('orders.api_created_at', null)
                    ->where('orders.created_at', '>=', $today);
            })
            ->get();

        //num of orders in today
        $todayNumOfOrders = count($todayOrders);

        //today profit

        foreach ($todayOrders as $order) {
            $todayProfit += $order->getOrderProfit();
        }

        $todayProfit = ceil($todayProfit / 1000);

        return view('index', compact('days', 'profit', 'productValue', 'todayProfit', 'todayNumOfOrders'));
    }
}
