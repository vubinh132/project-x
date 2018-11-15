<?php

namespace App\Http\Controllers\external_apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommonService;
use App\SDKs\lazada\lazop\LazopClient;
use App\SDKs\lazada\lazop\UrlConstants;
use App\SDKs\lazada\lazop\LazopRequest;

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
        return view('external_apis.lazada.index');
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
