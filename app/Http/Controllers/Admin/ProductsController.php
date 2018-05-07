<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Log, File, Session;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::orderBy('sku')->get();

        $total = count($products);


        return view('admin.products.index', compact('products', 'total'));
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
            'name' => " required",
            'old_price' => "required|numeric|min:0",
            'price' => "required|numeric|min:0",
            'description' => "required",
            'content' => 'html_required'

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


}
