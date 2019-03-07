<?php

namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use App\Models\Role;
use App\Services\CommonService;
use App\Services\LogService;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $perPage = config('constants.PAGE_SIZE');

        $roles = Role::orderBy('code');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $roles = $roles->where(function ($query) use ($keyword) {
                $query->orWhere('roles.name', 'LIKE', $keyword);
                $query->orWhere('roles.code', 'LIKE', $keyword);
            });
        }

        $roles = $roles->paginate($perPage);

        session(['mainPage' => $request->fullUrl()]);

        $total = Role::count();


        return view('roles.index', compact('roles', 'total'));
    }
}
