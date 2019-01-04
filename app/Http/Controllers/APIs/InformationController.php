<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Log, DB, Exception;
use App\Models\Product;


class InformationController extends Controller
{

    public function getGeneralInformation()
    {
        try {
            $data = ApiService::getGeneralInformation();
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'internal server error'
            ], 500);
        }

    }

    public function getProductRepository($id)
    {
        try {
            $product = Product::where('status', Product::STATUS['IN_BUSINESS'])->findOrFail($id);
            $repository = $product->getAvailableQuantity() - $product->getNotReturnedQuantity();
            return [
                'success' => true,
                'data' => [
                    'productRepository' => $repository,
                ]
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [
                'success' => false,
                'massage' => $e->getMessage()
            ];
        }

    }


}
