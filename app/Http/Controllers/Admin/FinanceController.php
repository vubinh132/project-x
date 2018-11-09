<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CommonService;
use App\Services\HTMLService;
use Illuminate\Http\Request;
use App\Models\Product;
use Log, File, Session, DB, Exception;


class FinanceController extends Controller
{
    public function import()
    {
        $result = [];

        $providers = Order::selectRaw('orders.provider, count(DISTINCT orders.id) as num_of_orders, -sum(order_details.price) as total_value')
            ->join('order_details', 'order_details.order_id', 'orders.id')
            ->join('products', 'products.id', 'order_details.product_id')
            ->where('orders.status', Order::STATUS['INTERNAL'])
            ->groupBy('orders.provider')
            ->get();

        return view('admin.finance.import', compact('providers'));
    }


    public function importDetail($providerId)
    {
        $orders = Order::selectRaw('orders.id, orders.code, orders.name, orders.note, orders.created_at,sum(order_details.quantity) as quantity, -sum(order_details.price) as total_price')->join('order_details', 'order_details.order_id', 'orders.id')
            ->join('products', 'products.id', 'order_details.product_id')
            ->where('orders.status', Order::STATUS['INTERNAL'])
            ->where('provider', $providerId)
            ->groupBy('orders.id', 'orders.code', 'orders.name', 'orders.note', 'orders.created_at')
            ->orderBy('orders.id')
            ->get();

        $totalPrice = (array_sum($orders->pluck('total_price')->toArray()));

        $total = count($orders);

        return view('admin.finance.import_detail', compact('orders', 'totalPrice', 'total'));
    }


}
