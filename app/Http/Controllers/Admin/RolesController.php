<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityHistory;
use App\Models\Role;
use App\Models\User;
use App\Services\CommonService;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        $canManageRoles = CommonService::checkPermission('ROLES_MANAGE');

        return view('admin.roles.index', compact('roles', 'total', 'canManageRoles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $permissionGroups = Role::PERMISSION_GROUPS;
        return view('admin.roles.create', compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:roles,code|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u',
        ]);
        $requestData = $request->all();

        $permissions = '';

        foreach (Role::PERMISSIONS as $key => $value) {
            if (!empty($requestData[$value]) && $requestData[$value] == 1) {
                $permissions = $permissions . "$value,";
            }
        }


        if (empty($permissions)) {
            $permissions = null;
        } else {
            $permissions = substr($permissions, 0, -1);
        }

        $requestData['permissions'] = $permissions;


        Role::create($requestData);

        LogService::Log('Tạo role: ' . $request->name, ActivityHistory::CATEGORIES['USER']);

        Session::flash('flash_message', 'Đã thêm role mới!');

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissionGroups = Role::PERMISSION_GROUPS;
        $permissionList = explode(',', $role->permissions);
        return view('admin.roles.show', compact('role', 'permissionGroups', 'permissionList'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissionGroups = Role::PERMISSION_GROUPS;
        $permissionList = explode(',', $role->permissions);
        return view('admin.roles.edit', compact('role', 'permissionGroups', 'permissionList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => "required|unique:roles,code,$id|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u",
        ]);
        $requestData = $request->all();

        $permissions = '';

        foreach (Role::PERMISSIONS as $key => $value) {
            if (!empty($requestData[$value]) && $requestData[$value] == 1) {
                $permissions = $permissions . "$value,";
            }
        }

        if (empty($permissions)) {
            $permissions = null;
        } else {
            $permissions = substr($permissions, 0, -1);
        }

        $requestData['permissions'] = $permissions;

        $role = Role::findOrFail($id);
        $role->update($requestData);

        LogService::Log('Cập nhật quyền của: ' . $request->name, ActivityHistory::CATEGORIES['USER']);

        Session::flash('flash_message', 'Đã cập nhật quyền!');

        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if (User::where('role_id', '=', $id)->count() > 0) {
            Session::flash('flash_error', 'Không thể xóa vì có người dùng thuộc quyền này!');
        } else {
            $role = Role::findOrFail($id);
            Role::destroy($id);
            LogService::Log('Xoá phân quyền: ' . $role->name, ActivityHistory::CATEGORIES['USER']);
            Session::flash('flash_message', 'Đã xóa phân quyền!');
        }
        return redirect('admin/roles');
    }
}
