<?php

namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\HTMLService;
use App\Models\Log;
use Exception;


class ROMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $notification = Log::where('category', Log::CATEGORY['ROM'])->orderBy('created_at', 'desc')->first();
        $notification = $notification ? $notification->content . ' at ' . $notification->created_at : '';

        $orders = Order::with(['products' => function ($query) {
            $query->orderBy('sku');
        }])
            ->where('orders.status', Order::STATUS['RETURNED'])
            ->orderBy('orders.created_at', 'desc')->get();

        foreach ($orders as $order) {
            $order->code = $order->getCode();
            $order->statusText = $order->statusText();
            $order->totalPrice = HTMLService::getOrderTotalPrice($order);
            $order->sellingWeb = $order->sellingWebText();
            $order->editLink = url('/admin/orders/' . $order->id . '/edit');
            $order->orderDetail = HTMLService::getOrderDetails($order->products);
            $order->created_at = $order->getCreatedAt();
            $order->returned = $order->returned ? true : false;
        }

        return view('rom.index', compact('orders', 'notification'));

    }

    public function changeReturnStatus(Request $request, $id)
    {
        try {
            $status = $request->get('status') == 0 ? false : true;

            $order = Order::where('id', $id)->where('status', Order::STATUS['RETURNED'])->firstOrFail();

            $order->update(['returned' => $status]);

            return response()->json([
                    'success' => true]
            );

        } catch (Exception $e) {
            return response()->json([
                    'success' => false]
            );
        }
    }

    public function commit()
    {
        $received = Order::where('status', Order::STATUS['RETURNED'])->where('returned', true)->count();
        Log::create([
            'category' => Log::CATEGORY['ROM'],
            'content' => "$received orders have been received",
            'notification_type' => Log::NOTIFICATION_TYPE['NONE']
        ]);
        return redirect('/rom');
    }

}