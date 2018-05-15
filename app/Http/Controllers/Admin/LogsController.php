<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Log, File, Session;
use App\Models\Log as LogModel;
use Illuminate\Http\Request;


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
        $categories = LogModel::getCategories();
        return view('admin.logs.index', compact('logs', 'categories'));
    }

    public function list(Request $request)
    {
        $id = $request->get('category');
        if (!$id) {
            $logs = LogModel::orderBy('created_at', 'desc')->take(50)->get();
        } else {
            $logs = LogModel::where('category', $id)->orderBy('created_at', 'desc')->take(50)->get();
        }

        foreach ($logs as $log){
            $log->categoryText = $log->categoryText();
        }
        return response()->json([

            'success' => true,

            'data' => $logs

        ]);
    }

}
