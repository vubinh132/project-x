<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Log, DB, Exception;
use App\Models\Order;


/**
 * Class OrdersController
 * @package App\Http\Controllers\APIs
 */
class OrdersController extends Controller
{


    public function getOrders(Request $request)
    {
        try {
            $orderCode = $request->get('orderCode');
            $conditions = $request->get('conditions');
            $maxResults = $request->get('maxResults');
            $orders = Order::select('id', 'code', 'status', 'name', 'selling_web', 'created_at', 'api_created_at')
                ->orderBy('created_at', 'desc')
                ->with(['productsWithoutPivots' => function ($query) {
                    $query->select('products.id', 'sku');
                    $query->orderBy('sku');
                    $query->withPivot('price', 'quantity');
                }]);

            if (!empty($orderCode)) {
                $orders = $orders->where(function ($query) use ($orderCode) {
                    $query->where('code', 'like', "%$orderCode%")
                        ->orWhere(function ($query) use ($orderCode) {
                            $query->where('status', Order::STATUS['INTERNAL'])
                                ->where('id', 'like', '%' . ltrim($orderCode, '0') . '%');
                        });
                });
            }

            $orders = $orders->whereIn('status', $conditions ? $conditions : []);

            if ($maxResults && $maxResults < 100)
                $orders = $orders->take($maxResults)->get();
            else
                $orders = $orders->take(100)->get();

            //handle raw data
            $results = [];
            foreach ($orders as $order) {
                $result = ['id' => $order->id,
                    'code' => $order->code,
                    'status' => $order->status,
                    'name' => $order->name,
                    'sellingWeb' => $order->sellingWebText(),
                    'createdTime' => $order->getCreatedAt(),
                    'orderDetails' => []
                ];
                foreach ($order->productsWithoutPivots as $product) {
                    $result['orderDetails'][] = ['sku' => $product->sku, 'quantity' => $product->pivot->quantity];
                }
                $results[] = $result;
            }

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'massage' => $e->getMessage()
            ]);
        }
    }
}
