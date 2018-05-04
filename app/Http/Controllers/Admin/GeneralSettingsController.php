<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Log;


class GeneralSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $startDate = CommonService::getSettingChosenValue('START_DATE');
        $version = explode('|', CommonService::getSettingChosenValue('VERSION_DETAILS'));

        return view('admin.general_settings.index', compact('startDate', 'version'));
    }

    public function update(Request $request)
    {

    }


}
