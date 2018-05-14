<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Log, File, Session;
use App\Models\Log as LogModel;


class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $logs = LogModel::orderBy('created_at', 'desc')->take(30)->get();
        
        return view('admin.logs.index', compact('logs'));
    }

}
