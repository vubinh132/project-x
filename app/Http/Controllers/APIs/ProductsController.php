<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Log, DB, Exception;


class ProductsController extends Controller
{
    public function checkQuantity(Request $request)
    {
        try {
            $this->validate($request, ['productId' => 'required|numeric']);
            $requestData = $request->all();
            $res = ApiService::checkQuantity($requestData['productId']);

            if (!$res['success']) {
                return response()->json([
                    'success' => false,
                    'massage' => $res['message']
                ]);
            }
            return response()->json([
                'success' => true
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
