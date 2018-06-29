<?php

namespace App\Http\Controllers\Admin\external_apis;

use App\Http\Controllers\Controller;
use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Log, Mail;
use Exception;
use App\Mail\SimpleEmailSender;


class GoogleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.external_apis.google.index');
    }



}