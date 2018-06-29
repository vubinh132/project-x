<?php

namespace App\Http\Controllers\Admin\external_apis;

use App\Http\Controllers\Controller;
use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Services\LazadaService;
use App\Services\CommonService;

use Log as Log1;


class LazadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('admin.external_apis.lazada.index');
    }

    public function syncOrders(Request $request)
    {
        $day = $request->get('day');

        $res = LazadaService::syncOrderByDay($day);

        return response()->json($res);
    }

    public function auth(Request $request)
    {
        $code = $request->get('code');
        Log1::info($code);
    }


}
