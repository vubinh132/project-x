<?php

namespace App\Http\Controllers;

use App\Models\ApiData;
use Log, File, Session, DB;


class InternalApisController extends Controller
{
    public function index()
    {

        $data = ApiData::get();
        return view('api_data.index', compact('data'));
    }


}
