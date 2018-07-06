<?php

namespace App\Http\Controllers\Admin\external_apis;

use App\Http\Controllers\Controller;
use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Services\LazadaService;
use App\Services\CommonService;
use App\SDKs\lazada\lazop\LazopClient;
use App\SDKs\lazada\lazop\UrlConstants;
use App\SDKs\lazada\lazop\LazopRequest;
use Carbon\Carbon;

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

    public function syncAllOrders(Request $request)
    {

        $startDay = (new Carbon('2018-03-05'))->startOfDay();
        $endDay = Carbon::now()->startOfDay();
        while ($endDay >= $startDay) {
            $res = LazadaService::syncOrderByDay($startDay);
            $result[] = [$startDay->toIso8601String(), $res];
            $startDay->addDay(1);
        }

        return response()->json($result);
    }
    
    public function auth(Request $request)
    {
        $code = $request->get('code');
        $c = new LazopClient(UrlConstants::$api_authorization_url, config('lazada.APP_KEY'), config('lazada.APP_SECRET'));
        $r = new LazopRequest("/auth/token/create");
        $r->addApiParam("code", $code);
        $response = $c->execute($r);
        $res = json_decode($response);
        $token = $res->access_token;
        CommonService::updateSettingValue("L_TOKEN", $token);

        return response()->json(['success' => true]);

    }


}
