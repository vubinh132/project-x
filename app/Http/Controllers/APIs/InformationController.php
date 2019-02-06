<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Log, DB, Exception;
use App\Models\Product;
use App\Models\Log as LogModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;


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

    public function getProductData($wildcard)
    {
        try {
            $products = Product::where('status', Product::STATUS['IN_BUSINESS'])
                ->where('sku', 'like', "%$wildcard%")
                ->get();
            if (count($products) > 1) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'isProductList' => true,
                        'productList' => $products->pluck('sku')
                    ]
                ]);
            } elseif (count($products) == 1) {
                $product = $products[0];
                return response()->json([
                    'success' => true,
                    'data' => [
                        'isProductList' => false,
                        'product' => [
                            'id' => $product->id,
                            'sku' => $product->sku,
                            'image' => $product->getImageLinkOnDropbox(),
                            'repository' => $product->getAvailableQuantity() - $product->getNotReturnedQuantity(),
                            'lastQuantityCheckingTime' => $product->quantity_checking_time
                        ]
                    ]
                ]);
            }

            throw new ModelNotFoundException('can not find any product');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [
                'success' => false,
                'massage' => $e->getMessage()
            ];
        }

    }

    public function getLogs($numberOfLogs)
    {
        try {

            $logs = LogModel::orderBy('created_at', 'desc')
                ->take($numberOfLogs)
                ->get(['created_at', 'category', 'content']);
            return response()->json([
                'success' => true,
                'data' => $logs
            ]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [
                'success' => false,
                'massage' => $e->getMessage()
            ];
        }

    }


}
