<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Log, DB, Exception;


class InformationController extends Controller
{

    public function getGeneralInformation(Request $request)
    {
        try {
            $data = ApiService::getGeneralInformation();
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'internal server error'
            ], 500);
        }

    }


}
