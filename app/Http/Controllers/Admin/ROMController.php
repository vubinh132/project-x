<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityHistory;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\HTMLService;
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
        $orders = Order::where('status', Order::STATUS['RETURNED'])->orderBy('created_at', 'desc')->get();

        foreach ($orders as $order) {
            $order->code = $order->getCode();
            $order->statusText = $order->statusText();
            $order->totalPrice = HTMLService::getOrderTotalPrice($order);
            $order->sellingWeb = $order->sellingWebText();
            $order->editLink = url('/admin/orders/' . $order->id . '/edit');
            $order->orderDetail = HTMLService::getOrderDetails($order);
            $order->created_at = $order->getCreatedAt();
            $order->returned = $order->returned ? true : false;
        }

        return view('admin.rom.index', compact('orders'));

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

}
