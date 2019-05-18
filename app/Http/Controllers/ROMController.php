<?php

namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\HTMLService;
use App\Models\Log;
use Exception;
Use Illuminate\Support\Facades\Auth;


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
            ->where('orders.status', Order::STATUS['NOT_RECEIVED'])
            ->orderBy('orders.created_at', 'desc')->get();

        foreach ($orders as $order) {
            $order->code = $order->getCode();
            $order->statusText = $order->statusText();
            $order->totalPrice = HTMLService::getOrderTotalPrice($order);
            $order->sellingWeb = $order->sellingWebText();
            $order->editLink = url('/admin/orders/' . $order->id . '/edit');
            $order->orderDetail = HTMLService::getOrderDetails($order->products);
            $order->created_at = $order->getCreatedAt();
            $order->returned = $order->status == Order::STATUS['RECEIVED'] ? true : false;
        }

        return view('rom.index', compact('orders', 'notification'));

    }

    public function changeReturnStatus(Request $request, $id)
    {
        try {
            $status = $request->get('status') == 0 ? Order::STATUS['NOT_RECEIVED'] : Order::STATUS['RECEIVED'];

            $order = Order::where('id', $id)->whereIN('status', [Order::STATUS['NOT_RECEIVED'], Order::STATUS['RECEIVED']])->firstOrFail();

            $order->update(['status' => $status], ['isManual' => true, 'entity' => Auth::user()]);

            return response()->json([
                    'success' => true,
                    'data' => [
                        'status' => $order->status
                    ]
                ]
            );

        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function commit()
    {
        $received = Order::where('status', Order::STATUS['RECEIVED'])->count();
        Log::create([
            'category' => Log::CATEGORY['ROM'],
            'content' => "$received orders have been received",
            'notification_type' => Log::NOTIFICATION_TYPE['NONE']
        ]);
        return redirect('/rom');
    }

    public function getView(){
        return view('layouts.app_react');
    }

}
