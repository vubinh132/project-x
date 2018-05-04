<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use Log, DB;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //start date
        $startDay = new Carbon(CommonService::getSettingChosenValue('START_DATE'));
        $diffInSeconds = (new Carbon($startDay))->diffInSeconds(Carbon::now());
        $days = ceil($diffInSeconds / (24 * 3600));

        //product value
        $productValue = 0;
        $products = Product::where('status', Product::STATUS['IN_BUSINESS'])->get();
        foreach ($products as $product){
            $productValue += ($product->getAvailableQuantity() * $product->getAVGValue());
        }
        $productValue = ceil($productValue/1000);

        //profit
        $profit = ceil(Order::join('order_details','orders.id', 'order_details.order_id')->whereIn('orders.status', [Order::STATUS['PAID'], Order::STATUS['INTERNAL']])->sum('order_details.price') / 1000);

        return view('admin.index', compact('days', 'profit', 'productValue'));
    }
}
