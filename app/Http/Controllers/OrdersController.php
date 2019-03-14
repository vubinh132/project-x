<?php

namespace App\Http\Controllers;

use App\Services\HTMLService;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Log, File, Session, DB, Auth;
use App\Services\CommonService;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $total = Order::count();
        $processing = Order::where('status', Order::STATUS['ORDERED'])->count();
        $done = Order::whereIn('status', [Order::STATUS['PAID'], Order::STATUS['INTERNAL']])->count();
        $canceled = Order::whereIn('status', [Order::STATUS['CANCELED'], Order::STATUS['RETURNED'], Order::STATUS['LOST']])->count();

        return view('orders.index', compact('total', 'processing', 'done', 'canceled'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $products = Product::where('status', Product::STATUS['IN_BUSINESS'])->orderBy('sku')->get()->pluck('id', 'sku');
        return view('orders.create', compact('products'));
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
        $validate_list = [
            'name' => 'required',
            'numOfProducts' => 'required'
        ];

        $requestData = $request->all();

        //parsing price
        for ($i = 1; $i <= $requestData['numOfProducts']; $i++) {
            $requestData['price_' . $i] = (int)str_replace(',', '', $requestData['price_' . $i]);
        }

        $products = [];

        $numOfProduct = $requestData['numOfProducts'];

        if ($requestData['status'] == Order::STATUS['ORDERED'] || $requestData['status'] == Order::STATUS['PAID']) {
            unset($requestData['provider']);
            $validate_list['selling_web'] = 'required';
            if ($requestData['selling_web'] == Order::SELLING_WEB['SELF']) {
                unset($requestData['code']);
                $this->validate($request, $validate_list);
            } else {
                $validate_list['code'] = 'required';
                $this->validate($request, $validate_list);
                $requestData['code'] = $requestData['selling_web'] == Order::SELLING_WEB['LAZADA'] ? 'L-' . $requestData['code'] : 'S-' . $requestData['code'];
            }
            for ($i = 1; $i <= $numOfProduct; $i++) {
                $price = $requestData['price_' . $i];
                $quantity = -($requestData['quantity_' . $i]);
                //sell and adjust quantity -> price always >= 0
                if ($price >= 0 && $quantity) {
                    array_push($products, [$requestData['product_id_' . $i], $quantity, $price]);
                }
            }

        } elseif ($requestData['status'] == Order::STATUS['INTERNAL']) {

            $validate_list = [
                'provider' => 'required',
                'numOfProducts' => 'required'
            ];

            $this->validate($request, $validate_list);

            unset($requestData['selling_web']);
            unset($requestData['code']);
            unset($requestData['name']);
            unset($requestData['phone']);
            unset($requestData['email']);
            unset($requestData['address']);
            unset($requestData['address_test']);

            $requestData['name'] = Order::PROVIDER_TEXT[array_keys(Order::PROVIDER, $requestData['provider'])[0]];

            for ($i = 1; $i <= $numOfProduct; $i++) {
                $price = $requestData['operation_' . $i] == 1 ? $requestData['price_' . $i] : -($requestData['price_' . $i]);

                $quantity = $requestData['operation_' . $i] == 1 ? -($requestData['quantity_' . $i]) : $requestData['quantity_' . $i];

                if ($price && $quantity) {
                    array_push($products, [$requestData['product_id_' . $i], $quantity, $price]);
                }
            }

        } else {
            Session::flash('flash_error', 'Status of this order is incorrect!');
            return redirect('orders/create');
        }

        DB::transaction(function () use ($requestData, $products) {

            $order = Order::create($requestData, ['isManual' => true, 'entity' => Auth::user()]);

            foreach ($products as $product) {
                $order->products()->attach($product[0], ['quantity' => $product[1], 'price' => $product[2]]);
            }

        });
        return redirect('orders');
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
        $order = Order::findOrFail($id);

        $logs = $order->logs;

        $statusList = [];

        if ($order->status == Order::STATUS['PAID'] || $order->status == Order::STATUS['ORDERED'] || $order->status == Order::STATUS['CANCELED']) {
            //if order status is ordered, paid, cancelled
            $statusList = CommonService::mapStatus(Order::STATUS, Order::STATUS_TEXT, [Order::STATUS['ORDERED'], Order::STATUS['PAID'], Order::STATUS['CANCELED'], Order::STATUS['RETURNED']]);
        } elseif ($order->status == Order::STATUS['INTERNAL']) {
            //if order status is internal
            $statusList = CommonService::mapStatus(Order::STATUS, Order::STATUS_TEXT, [Order::STATUS['INTERNAL']]);
        } elseif ($order->status == Order::STATUS['RETURNED'] && $order->returned) {
            //if order status is return and have been received
            $statusList = CommonService::mapStatus(Order::STATUS, Order::STATUS_TEXT, [Order::STATUS['RETURNED']]);
        } elseif ($order->status == Order::STATUS['RETURNED'] && !$order->returned) {
            //if order status is return and have not been received
            $statusList = CommonService::mapStatus(Order::STATUS, Order::STATUS_TEXT, [Order::STATUS['RETURNED'], Order::STATUS['LOST'], Order::STATUS['PAID']]);
        } elseif ($order->status == Order::STATUS['LOST']) {
            //if order status is lost
            $statusList = CommonService::mapStatus(Order::STATUS, Order::STATUS_TEXT, [Order::STATUS['LOST']]);
        }

        return view('orders.edit', compact('order', 'statusList', 'logs'));
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
        $order = Order::findOrFail($id);

        //can not update internal order
        if ($order->status != Order::STATUS['INTERNAL']) {

            $this->validate($request, [
                'status' => "required",
                'name' => " required",
            ]);
            $requestData = $request->all();

        } else {
            //just update note for internal orders
            $requestData = ['note' => $request->get('note')];
        }

        $order->update($requestData, ['isManual' => true, 'entity' => Auth::user()]);

        Session::flash('flash_message', 'Updated!');

        return redirect('orders');
    }

    public function getOrders(Request $request)
    {
        try {
            $orderCode = $request->get('orderCode');
            $conditions = $request->get('conditions');
            $orders = Order::orderBy('created_at', 'desc')
                ->with(['products' => function ($query) {
                    $query->orderBy('sku');
                }]);

            if (!empty($orderCode)) {
                $orders = $orders->where('code', 'like', "%$orderCode%");
            }

            $orders = $orders->whereIn('status', $conditions ? $conditions : []);

            $orders = $orders->take(100)->get();

            foreach ($orders as $order) {
                $order->code = $order->getCode();
                $order->statusText = $order->statusText();
                $order->totalPrice = HTMLService::getOrderTotalPrice($order);
                $order->sellingWeb = $order->sellingWebText();
                $order->editLink = url('/orders/' . $order->id . '/edit');
                $order->orderDetail = HTMLService::getOrderDetails($order->products);
                $order->created_at = $order->getCreatedAt();
                unset($order->products);
            }
            return response()->json(['success' => true, 'data' => $orders]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'internal server error'
            ], 500);
        }
    }

}
