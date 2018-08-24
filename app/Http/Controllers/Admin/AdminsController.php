<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CommonService;
use App\Services\LazadaService;
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

        //get today profit and revenue
        $today = Carbon::now()->startOfDay();

        $todayFund = 0;

        $todayRevenue = 0;

        //[[{product id}, {quantity}], .....]
        $formattedOrderDetails = [];

        $orderDetails = DB::table('order_details'
        )->join('orders', 'orders.id', 'order_details.order_id')
            ->whereIn('orders.status', [Order::STATUS['ORDERED'], Order::STATUS['PAID']])
            ->where('orders.api_created_at', '>', $today)
            ->get(['order_details.price', 'order_details.product_id', 'order_details.quantity']);

        foreach ($orderDetails as $orderDetail) {
            $todayRevenue += $orderDetail->price;
            $flag = false;
            $productId = $orderDetail->product_id;
            $quantity = $orderDetail->quantity;
            for ($i = 0; $i < count($formattedOrderDetails); $i++) {
                if ($formattedOrderDetails[$i][0] == $productId) {
                    $formattedOrderDetails[$i][1] += (-$quantity);
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                $formattedOrderDetails[] = [$productId, -$quantity];
            }
        }

        foreach ($formattedOrderDetails as $formattedOrderDetail) {
            $productId = $formattedOrderDetail[0];
            $quantity = $formattedOrderDetail[1];
            $availableQuantity = Product::find($productId)->getAvailableQuantity();
            $prices = DB::table('order_details')
                ->join('products', 'products.id', 'order_details.product_id')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('products.id', $productId)
                ->where('orders.status', Order::STATUS['INTERNAL'])
                ->orderBy('order_details.created_at', 'desc')
                ->get(['order_details.quantity', 'order_details.price']);
            foreach ($prices as $price) {
                $pQuantity = abs($price->quantity);
                $pPrice = abs($price->price) / $pQuantity;
                $flag = false;
                for ($i = 0; $i < $pQuantity; $i++) {
                    if ($availableQuantity > 0) {
                        $availableQuantity--;
                    } else {
                        $todayFund += $pPrice;
                        $quantity--;
                        if ($quantity == 0) {
                            $flag = true;
                            break;
                        }
                    }
                }
                if ($flag) {
                    break;
                }
            }
        }

        $todayProfit = ceil(($todayRevenue - $todayFund) / 1000);

        return view('admin.index', compact('days', 'profit', 'productValue', 'todayProfit'));
    }
}
