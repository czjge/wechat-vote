<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions = null)
    {
        if (! Auth::guard('admin')->user()->can(explode('|', $permissions))) {
            abort(403);
        }

        return $next($request);
    }
}
