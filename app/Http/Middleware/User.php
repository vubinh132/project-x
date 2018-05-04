<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check() && !Auth::user()->isLocked()) {
            return $next($request);
        } elseif(!Auth::check()){
            Session::flash('flash_message', 'Login failed');
        } elseif (Auth::user()->isLocked()){
            Session::flash('flash_message', 'Your account is blocked.');
        }

        Auth::logout();
        return redirect('/login');
    }
}
