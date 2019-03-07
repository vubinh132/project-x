<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
Use Log, Location;
use App\Models\Role;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $adminRoleId = Role::where('allows_login_cms', true)->first()->id;

        return array_merge($request->only($this->username(), 'password'), ['is_locked' => false, 'role_id' => $adminRoleId]);
    }

    protected function authenticated(Request $request, $user)
    {

//        if (!($user->isAdmin())) {
//            Session::flash('flash_message', 'Login successfully.');
//            $this->redirectTo = "/";
//        } else {
//            $ip = $request->ip();
//            $agent = new Agent();
//            $position = Location::get($ip);
//            $content = "You have logged in: IP address: $ip | Location: $position->cityName - $position->countryCode | Device: " . $agent->device() . ', OS: ' . $agent->platform() . ' ' . $agent->version($agent->platform()) . ', Browser: ' . $agent->browser() . ' ' . $agent->version($agent->browser());
//            $log = [
//                'category' => LogModel::CATEGORY['SECURITY'],
//                'content' => $content,
//                'notification_type' => LogModel::NOTIFICATION_TYPE['NONE']
//            ];
//            LogModel::create($log);
//
//        }

    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        Session::flash('flash_error', 'Login failed.');
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

    public function username()
    {
        return 'username';
    }
}
