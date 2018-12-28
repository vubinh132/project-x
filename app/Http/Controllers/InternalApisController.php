<?php

namespace App\Http\Controllers;

use App\Models\ApiData;
use Log, File, Session, DB;
use Exception;


class InternalApisController extends Controller
{
    public function index()
    {
        $data = ApiData::get();
        return view('api_data.index', compact('data'));
    }

    public function switchLock($id)
    {
        try {
            $data = ApiData::findOrFail($id);
            $isLocked = !($data->is_locked ? true : false);
            $data->update(['is_locked' => $isLocked]);
            return response()->json([
                'success' => true,
                'isLocked' => $isLocked
            ]);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'success' => false,
                'massage' => $e->getMessage()
            ]);
        }
    }
}
