<?php

namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use App\Models\Role;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
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

        $isUser = $request->get('is_user') == 1;
        $isAdmin = $request->get('is_admin') == 1;

        if (!$isUser && !$isAdmin) {
            $isUser = true;
            $isAdmin = true;
        }

        $users = User::orderBy('username');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $users = $users->where(function ($query) use ($keyword) {
                $query->orWhere('username', 'LIKE', $keyword);
                $query->orWhere('email', 'LIKE', $keyword);
                $query->orWhere('phone', 'LIKE', $keyword);
            });
        }

        if ($isUser && !$isAdmin) {
            $users = $users->whereNull('role_id');
        } elseif (!$isUser && $isAdmin) {
            $users = $users->whereNotNull('role_id');
        }

        $users = $users->paginate($perPage);

        session(['mainPage' => $request->fullUrl()]);

        $total = User::count();

        return view('users.index', compact('users', 'isUser', 'isAdmin', 'total'));
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
        $user = User::findOrFail($id);
        $isMyProfile = false;
        return view('users.show', compact('user', 'isMyProfile'));
    }

    public function myProfile()
    {
        $user = Auth::user();
        $isMyProfile = true;

        return view('users.show', compact('user', 'isMyProfile'));
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
        $user = User::findOrFail($id);
        $isMyProfile = false;
        $roles = [null => 'Choose Role'];
        foreach (Role::all() as $role) {
            $roles = $roles + [$role->id => $role->name];
        }
        return view('users.edit', compact('user', 'isMyProfile', 'roles'));
    }

    public function editMyProfile()
    {
        $user = Auth::user();
        $isMyProfile = true;

        return view('users.edit', compact('user', 'isMyProfile'));
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
        $this->updateData($id, $request, false);
        return redirect(CommonService::getPreviousUrl($request));
    }

    public function updateProfile(Request $request)
    {
        $this->updateData(Auth::id(), $request, true);

        return redirect('my-profile');
    }

    public function changeProfileImage(Request $request)
    {
        $user = Auth::user();

        // create new file
        $photoName = time() . '.' . $user->id . '.' . $request->user_photo->getClientOriginalExtension();
        $request->user_photo->move(public_path(config('constants.AVATAR_PROFILE_FOLDER')), $photoName);

        // remove old file
        if (!empty($user->image_1)) {
            $oldFilePath = public_path(config('constants.AVATAR_PROFILE_FOLDER')) . '/' . $user->image_1;
            if (File::exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // update user image
        $user->image_1 = $photoName;
        $user->save();

        return redirect('my-profile/edit');
    }

    public function changeUserProfileImage($id, Request $request)
    {

        $user = User::findOrFail($id);
        // create new file
        $photoName = time() . '.' . $user->id . '.' . $request->user_photo->getClientOriginalExtension();
        $request->user_photo->move(public_path(config('constants.AVATAR_PROFILE_FOLDER')), $photoName);

        // remove old file
        if (!empty($user->image_1)) {
            $oldFilePath = public_path(config('constants.AVATAR_PROFILE_FOLDER')) . '/' . $user->image_1;
            if (File::exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // update user image
        $user->image_1 = $photoName;
        $user->save();

        return redirect("users/$user->id/edit");
    }

    private function updateData($id, Request $request, $isMyProfile)
    {
        $user = User::findOrFail($id);

        $minAge = 18;

        $validateList = [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'address' => 'max:300',
        ];

        if (!empty($request->get('birth_day'))) {
            $validateList['birth_day'] = "before:-$minAge years";
        }

        $message = [
            'birth_day.before' => "User age must be older than $minAge years old",
        ];

        if ($isMyProfile) {
            $validateList['email'] = "required|string|email|max:255|unique:users,email,$id";
            if (!empty($request->get('phone'))) {
                $validateList['phone'] = "min:10|max:11|unique:users,phone,$id|regex:/^[0-9]+$/";
            }
        }

        $this->validate($request, $validateList, $message);

        $requestData = $request->all();

        if (!$isMyProfile) {
            unset($requestData['email']);
            unset($requestData['phone']);
        } else {
            unset($requestData['role_id']);
            unset($requestData['is_locked']);
        }

        $user->update($requestData);

        Session::flash('flash_message', 'Profile has been updated!');

        return $user;
    }


}
