<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\HTMLService;
use Illuminate\Http\Request;
use App\Models\Product;
use Log, File, Session, DB;
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
            $product->editLink = url('/admin/products/' . $product->id . '/edit');
            $product->deleteLink = url('/admin/products/' . $product->id . '/delete');
            $array = $product->getAVGProfit();
            $product->avgProfit = HTMLService::getAVGProfit($array);
            $product->avgProfitDetails = HTMLService::getAVGProfitDetails($array);
            $product->sellingSpeed = $product->getSellingSpeed();
            $product->sellingSpeedDetails = HTMLService::getSellingSpeedDetails($product->getSellingSpeedDetails());

        }

        $research = Product::where('status', Product::STATUS['RESEARCH'])->count();
        $in = Product::where('status', Product::STATUS['IN_BUSINESS'])->count();
        $out = Product::where('status', Product::STATUS['OUT_OF_BUSINESS'])->count();

        return view('admin.products.index', compact('products', 'total', 'research', 'in', 'out'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.products.create');
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

        return redirect('admin/products');
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


        return view('admin.products.edit', compact('product'));
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

        return redirect('admin/products');
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
        return redirect('admin/products');
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

        return redirect('admin/products/' . $id . '/edit');
    }

//    public function getUnitPrice($id)
//    {
//        try {
//            $product = Product::where('id', $id)->where('status', Product::STATUS['IN_BUSINESS'])->firstOrFail(['price']);
//
//            return response()->json([
//                'success' => true,
//                'data' => $product
//
//            ]);
//
//        } catch (Exception $e) {
//            Log::error($e->getMessage());
//            return response()->json([
//                'success' => false,
//
//            ]);
//        }
//    }

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
        $res = LazadaService::getProductQuantity();
        if (!$res['success']) {
            return response()->json($res);
        }
        $LProducts = $res['products'];

        $products = DB::table('products')
            ->select(DB::raw('products.sku, sum(order_details.quantity) as available'))
            ->leftJoin('order_details', 'order_details.product_id', 'products.id')
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->where('products.status', Product::STATUS['IN_BUSINESS'])
            ->whereIn('orders.status', [Order::STATUS['ORDERED'], Order::STATUS['PAID'], Order::STATUS['INTERNAL']])
            ->groupBy('products.sku')
            ->get();
        foreach ($products as $product) {
            $sku = $product->sku;
            $flag = false;
            foreach ($LProducts as $key => $value) {
                if ($key == $sku) {
                    $product->l = $value;
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                $product->l = 'N/a';
            }
        }

        return view('admin.products.checking', compact('products'));

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

}
