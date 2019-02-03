<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ApiService;
use App\Services\CommonService;
use App\Services\HTMLService;
use Illuminate\Http\Request;
use App\Models\Product;
use Log, File, Session, DB, Exception;
use App\Services\LazadaService;
use App\Models\ShopProduct;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::orderBy('id')->get();

        $total = count($products);

        foreach ($products as $product) {
            $product->statusText = $product->statusText();
            $product->quantity = HTMLService::getProductQuantity($product);
            $product->avgValue = HTMLService::getAVGValue($product);
            $product->editLink = url('/products/' . $product->id . '/edit');
            $product->deleteLink = url('/products/' . $product->id . '/delete');
            $array = $product->getAVGProfit();
            $product->avgProfit = HTMLService::getAVGProfit($array);
            $product->avgProfitDetails = HTMLService::getAVGProfitDetails($array);
            $product->sellingSpeed = $product->getSellingSpeed();
            $product->sellingSpeedDetails = HTMLService::getSellingSpeedDetails($product->getSellingSpeedDetails());

        }

        $research = Product::where('status', Product::STATUS['RESEARCH'])->count();
        $in = Product::where('status', Product::STATUS['IN_BUSINESS'])->count();
        $out = Product::where('status', Product::STATUS['OUT_OF_BUSINESS'])->count();

        return view('products.index', compact('products', 'total', 'research', 'in', 'out'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sku' => 'required|unique:products,sku',
        ]);

        $requestData = $request->all();
        //set status default is 1
        $requestData['status'] = Product::STATUS['RESEARCH'];

        Product::create($requestData);

        return redirect('/products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);


        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'status' => "required",
            'sku' => " required|unique:products,sku,$id",
            'price' => "required|numeric|min:0",
        ]);
        $requestData = $request->all();

        $product = Product::findOrFail($id);

        $product->update($requestData);

        Session::flash('flash_message', 'Updated!');

        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product->canDelete()) {
            Session::flash('flash_error', 'Can\'t delete!');
        } else {
            $product->delete();
            Session::flash('flash_message', 'Delete!');
        }
        return redirect('/products');
    }

    public function changeImage($id, Request $request)
    {
        $this->validate($request, [
            'product_image' => 'required',
        ]);

        $product = Product::findOrFail($id);

        $imageName = time() . '.' . $product->id . '.' . $request->product_image->getClientOriginalExtension();

        $product->uploadImageToDropbox(file_get_contents($request->file('product_image')), $imageName);

        return redirect('/products/' . $id . '/edit');
    }

    public function getUnitPrice($id)
    {
        try {
            $product = Product::where('id', $id)->where('status', Product::STATUS['IN_BUSINESS'])->firstOrFail(['price']);

            return response()->json([
                'success' => true,
                'data' => $product

            ]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,

            ]);
        }
    }

    public function test()
    {
        $result = ['success' => true];
        $products = Product::where('status', Product::STATUS['IN_BUSINESS'])->get(['id', 'sku']);
        foreach ($products as $product) {
            $product['quantity'] = $product->getAvailableQuantity();
        }
        $result['products'] = $products;
        return response()->json($result);
    }

    public function productChecking()
    {
        //general data
        $remainLessThan0 = 0;
        $remainEqual0 = 0;
        $remainGreaterThan0 = 0;

        //get haven't received product
        $notReceivedProducts = DB::table('orders')
            ->select(DB::raw('order_details.product_id, sum(order_details.quantity) as quantity'))
            ->join('order_details', 'order_details.order_id', 'orders.id')
            ->where('orders.status', Order::STATUS['RETURNED'])
            ->where(function ($query) {
                $query->where('orders.returned', null)
                    ->orWhere('orders.returned', false);
            })
            ->groupBy('order_details.product_id')
            ->pluck('quantity', 'product_id');

        //get available by eager loading instead of getAvailableQuantity() function
        $products = DB::table('products')
            ->select(DB::raw('products.sku, sum(order_details.quantity) as available, products.id'))
            ->leftJoin('order_details', 'order_details.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->where('products.status', Product::STATUS['IN_BUSINESS'])
            ->whereIn('orders.status', [Order::STATUS['ORDERED'], Order::STATUS['PAID'], Order::STATUS['INTERNAL'], Order::STATUS['LOST']])
            ->groupBy('products.sku', 'products.id')
            ->orderBy('products.sku')
            ->get();

        //get shop product
        $shopProducts = ShopProduct::get(['sku', 'lazada', 'shopee']);
        //handle data
        $temp = [];
        foreach ($shopProducts as $element) {
            $temp[$element->sku] = ['lazada' => $element->lazada, 'shopee' => $element->shopee];
        }
        $shopProducts = $temp;

        //get list sku to compare
        $productList = $products->pluck('sku')->toArray();

        foreach ($products as $product) {
            $shopProduct = null;
            if (array_key_exists($product->sku, $shopProducts)) {
                $shopProduct = $shopProducts[$product->sku];
                unset($shopProducts[$product->sku]);
            }
            $product->notReceived = !empty($notReceivedProducts[$product->id]) ? -$notReceivedProducts[$product->id] : 0;
            $product->lazada = ($shopProduct && $shopProduct['lazada']) ? $shopProduct['lazada'] : 0;
            $product->lazadaDetail = ($shopProduct && is_numeric($shopProduct['lazada'])) ? [$product->sku => $shopProduct['lazada']] : [];
        }

        foreach ($shopProducts as $key => $value) {
            $sku = $sku = config('lazada.' . $key, $key);
            $lazada = $value['lazada'] ? $value['lazada'] : 0;
            //$shopee = $value['shopee'] ? $value['shopee'] : 0;
            //package
            if (str_contains($sku, '&')) {
                $SKUs = explode('&', $sku);
            } else {
                $SKUs = [$sku];
            }

            foreach ($SKUs as $SKU) {
                if (!in_array($SKU, $productList)) {
                    Log::error("Product checking: wrong sku $SKU");
                    CommonService::writeLog(\App\Models\Log::CATEGORY['ERROR'], "Product checking: wrong sku $SKU");
                } else {
                    foreach ($products as $product) {
                        if ($product->sku == $SKU) {
                            $product->lazada = $product->lazada + $lazada;
                            if (is_numeric($value['lazada'])) {
                                $product->lazadaDetail[$key] = $lazada;
                            }
                            break;
                        }
                    }
                }
            }
        }

        //data parsing
        foreach ($products as $product) {
            //HTML data parsing
            $available = $product->available;
            $notReceived = $product->notReceived;
            $selling = $product->lazada;
            $remain = $available - $notReceived - $selling;
            $product->quantityData = HTMLService::getQuantityData($available, $notReceived, $selling, $remain);
            $product->lazadaDetail = HTMLService::getCheckingDetail($product->lazadaDetail);

            if ($remain < 0) {
                $product->SKU = "<i class='fa fa-warning text-danger'></i> $product->sku";
                $remainLessThan0++;
            } elseif ($remain == 0) {
                $product->SKU = " <i class='fa fa-check-circle text-success'></i> $product->sku";
                $remainEqual0++;
            } else {
                $product->SKU = "<i class='fa fa-info-circle text-info'></i> $product->sku ";
                $remainGreaterThan0++;
            }
        }

        return view('products.checking', compact('products', 'remainLessThan0', 'remainEqual0', 'remainGreaterThan0'));
    }

    public function productCheckingTest()
    {
        $wrongSKUs = [];
        $res = LazadaService::getProductSKUs();
        if (!$res['success']) {
            return response()->json($res);
        }
        $LSKUs = $res['data'];
        $MSKUs = Product::where('status', Product::STATUS['IN_BUSINESS'])->orderBy('sku')->get(['sku'])->pluck('sku')->toArray();
        foreach ($LSKUs as $LSKU) {
            if (str_contains($LSKU, '&')) {
                $arraySKU = explode('&', $LSKU);
            } else {
                $arraySKU = [$LSKU];
            }
            foreach ($arraySKU as $sku) {
                if (!in_array($sku, $MSKUs)) {
                    $wrongSKUs[] = $LSKU;
                    break;
                }
            }
        }

        sort($wrongSKUs);

        return response()->json([
            'Ms. La' => [
                'count' => count($wrongSKUs),
                'SKUs' => $wrongSKUs
            ]
        ]);
    }

    public function updateQuantity(Request $request)
    {
        try {
            $this->validate($request, [
                'sku' => 'required',
                'quantity' => 'required|numeric'
            ]);

            $requestData = $request->all();

            $getQuantityRes = LazadaService::getQuantity($requestData['sku']);

            if (!$getQuantityRes['success']) {
                return response()->json($getQuantityRes);
            }

            $pending = Order::join('order_details', 'orders.id', 'order_details.order_id')
                ->join('products', 'products.id', 'order_details.product_id')
                ->where('orders.status', Order::STATUS['ORDERED'])
                ->where('products.sku', $requestData['sku'])
                ->sum('order_details.quantity');

            $quantity = $getQuantityRes['data']['quantity'] + $requestData['quantity'] - $pending;

            $setQuantityRes = LazadaService::setQuantity($requestData['sku'], $quantity);

            return response()->json($setQuantityRes);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    //volume adjustment

    public function getAdjustment()
    {
        $order = Order::where('id', 2063)->with(['products' => function ($query) {
            $query->orderBy('id');
        }])->first();
        return view('products.volume_adjustment', compact('order'));
    }

    public function postAdjustment(Request $request)
    {
        $id = $request->get('id');

        $isIncreasing = $request->get('isIncreasing') == 'true' ? true : false;

        $product = DB::table('order_details')->where('order_id', 2063)->where('product_id', $id)->first();

        if (!$product) {
            return response()->json(
                ['success' => false]
            );
        }

        $oldVolume = $product->quantity;

        if ($oldVolume >= 0 && !$isIncreasing) {
            return response()->json(
                ['success' => false]
            );
        }

        $newVolume = $isIncreasing ? $oldVolume - 1 : $oldVolume + 1;

        DB::table('order_details')->where('order_id', 2063)->where('product_id', $id)->update(['quantity' => $newVolume]);

        return response()->json(
            ['success' => true, 'quantity' => abs($newVolume)]
        );
    }

    public function checkQuantity($productId)
    {
        try {
            $res = ApiService::checkQuantity($productId);

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
