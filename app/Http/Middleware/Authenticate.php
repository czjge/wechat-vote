<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                // verify where to redirect if not authenticate.
                // once use this method, we must make sure that
                // all routes of admin must contain string "/admin".

                if (strpos($request->getRequestUri(), '/admin') === false) {
                    return redirect()->guest('login');
                } else {
                    return redirect()->guest('admin/login');
                }
            }
        }

        // to check if the user is locked.
        if (Auth::guard($guard)->user()->status == 1) {
            // first we need logout the user.
            Auth::guard($guard)->logout();
            return redirect()->route('admin.getLogin')->withErrors(['name'=>'用户被锁定。']);
        }

        return $next($request);
    }
}
