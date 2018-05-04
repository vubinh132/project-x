<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Product;
use Log;


class ProductsController extends Controller
{
    public function getProduct($id)
    {
        try {
            $product = Product::where('id', $id)->where('status', Product::STATUS['IN_BUSINESS'])->firstOrFail(['id', 'name', 'display_name', 'quantity', 'old_price', 'price', 'description', 'content', 'image_url']);
            if (!empty($product->image_url)) {
                $product->image_url = url(config('constants.PRODUCT_IMAGE_FOLDER') . '/' . $product->image_url);
            } else {
                $product->image_url = url('images/product.png');
            }
            return response()->json([
                'success' => true,
                'product' => $product

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,

            ]);
        }
    }

    public function getProducts(Request $request)
    {
        try {
            $this->validate($request, [
                'ids' => 'required'
            ]);
            $ids = $request->get('ids');

            $products = $product = Product::whereIn('id', $ids)->where('status', Product::STATUS['IN_BUSINESS'])->get(['id', 'name', 'display_name', 'quantity', 'old_price', 'price', 'description', 'content', 'image_url']);

            foreach ($products as $product) {
                if (!empty($product->image_url)) {
                    $product->image_url = url(config('constants.PRODUCT_IMAGE_FOLDER') . '/' . $product->image_url);
                } else {
                    $product->image_url = url('images/product.png');
                }
            }


            Log::info($ids);
            return response()->json([
                'success' => true,
                'products' => $products

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,

            ]);
        }
    }

}
