<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CommonService;
use Carbon\Carbon;
use App\Models\Order;
use Log, DB, Mail;
use App\Services\ApiService;
use App\Services\LazadaService;


class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()

    {
        $res = LazadaService::syncProducts();

        $data = ApiService::getGeneralInformation();

        return view('index', compact('data'));
    }
}
