<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Log, DB;


class InformationController extends Controller
{

    public function getGeneralInformation(Request $request)
    {
        $data = ApiService::getGeneralInformation();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    }


}
