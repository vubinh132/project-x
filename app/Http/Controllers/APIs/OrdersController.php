<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Log, DB;
use App\Services\CommonService;


class OrdersController extends Controller
{

    public function store(Request $request)
    {
        try {

            $requestData = $request->all();

            $requestData['status'] = Order::STATUS['ORDERED'];

            DB::transaction(function () use ($requestData) {

                $products = $requestData['products'];

                for ($i = 0; $i < count($products); $i++) {
                    $products[$i]['quantity'] = -($products[$i]['quantity']);
                }

                $requestData['selling_web'] = Order::SELLING_WEB['SELF'];

                $order = Order::create($requestData);

                $order->products()->attach($products);
            });

            return response()->json([

                'success' => true,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,

            ]);
        }
    }


}
