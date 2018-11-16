<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CommonService;
use App\Services\HTMLService;
use Illuminate\Http\Request;
use App\Models\Product;
use Log, File, Session, DB, Exception;
use App\Services\LazadaService;


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
        // create new file
        $photoName = time() . '.' . $product->id . '.' . $request->product_image->getClientOriginalExtension();
        $request->product_image->move(public_path(config('constants.PRODUCT_IMAGE_FOLDER')), $photoName);

        // remove old file
        if (!empty($product->image_url)) {
            $oldFilePath = public_path(config('constants.PRODUCT_IMAGE_FOLDER')) . '/' . $product->image_url;
            if (File::exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // update user image
        $product->image_url = $photoName;
        $product->save();

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

        $res = LazadaService::getProductQuantity();
        if (!$res['success']) {
            return response()->json($res);
        }
        $LProducts = $res['products'];

        $products = DB::table('products')
            ->select(DB::raw('products.sku, sum(order_details.quantity) as available, products.id'))
            ->leftJoin('order_details', 'order_details.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->where('products.status', Product::STATUS['IN_BUSINESS'])
            ->whereIn('orders.status', [Order::STATUS['ORDERED'], Order::STATUS['PAID'], Order::STATUS['INTERNAL']])
            ->groupBy('products.sku', 'products.id')
            ->get();

        //handle irregular products
        $productList = $products->pluck('sku')->toArray();
        $handledProduct = [];
        $irregularProducts = [];
        foreach ($LProducts as $key => $value) {
            if (!in_array($key, $productList)) {
                $irregularProducts[$key] = $value;
            }
        }
        foreach ($irregularProducts as $key => $value) {
            $sku = $sku = config('lazada.' . $key, $key);
            //package
            if (str_contains($sku, '&')) {
                $SKUs = explode('&', $sku);
            } else {
                $SKUs = [$sku];
            }

            foreach ($SKUs as $SKU) {
                if (!in_array($SKU, $productList)) {
                    Log::info("======= wrong sku $SKU =======");
                    CommonService::writeLog(\App\Models\Log::CATEGORY['ERROR'], "Product checking: wrong sku $SKU");
                } else {
                    if (!array_key_exists($SKU, $handledProduct)) {
                        $handledProduct[$SKU] = $value;
                    } else {
                        $quantity = $handledProduct[$SKU] + $value;
                        $handledProduct[$SKU] = $quantity;
                    }
                }
            }
        }

        //foreach products...
        foreach ($products as $product) {
            $sku = $product->sku;
            $flag = false;
            foreach ($LProducts as $key => $value) {
                if ($key == $sku) {
                    $product->l = $value;
                    unset($LProducts[$key]);
                    $flag = true;
                    break;
                }
            }
            //HTML data parsing
            $total = $product->available;
            $notReceived = !empty($notReceivedProducts[$product->id]) ? -$notReceivedProducts[$product->id] : 0;
            $irregular = !empty($handledProduct[$sku]) ? $handledProduct[$sku] : 0;
            $lzd = !empty($product->l) ? $product->l : 0;
            $quantity = HTMLService::getProductCheckingQuantity($total, $notReceived, $irregular, $lzd, $product->sku);
            $product->available = $quantity['html'];
            if (!$flag) {
                $product->l = 'N/a';
            }
            if ($quantity['remain'] < 0) {
                $product->SKU = "$product->sku <i class='fa fa-warning text-danger'></i>";
                $remainLessThan0++;
            } elseif ($quantity['remain'] == 0) {
                $product->SKU = "$product->sku <i class='fa fa-check-circle text-success'></i>";
                $remainEqual0++;
            } else {
                $product->SKU = "$product->sku <i class='fa fa-info-circle text-info'></i>";
                $remainGreaterThan0++;
            }
        }

        return view('admin.products.checking', compact('products', 'LProducts', 'remainLessThan0', 'remainEqual0', 'remainGreaterThan0'));
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
}
