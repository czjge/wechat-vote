<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = null)
    {
        if (! Auth::guard('admin')->user()->hasRole(explode('|', $roles))) {
            abort(403);
        }

        return $next($request);
    }
}
