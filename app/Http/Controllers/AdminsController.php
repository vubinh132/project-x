<?php

namespace App\Http\Controllers;

use Log, DB, Mail;
use App\Services\ApiService;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()

    {
        $data = ApiService::getGeneralInformation();

        return view('index', compact('data'));
    }
}
