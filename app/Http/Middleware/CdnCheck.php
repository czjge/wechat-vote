<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CdnCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $voteId = null)
    {
        $vote = DB::table('vote')->where('id', '=', $voteId)->first();
        $qiniu_cdn_path = $vote->cdn_status == 1 ? config('home.cndSite') : '';
        View::share('qiniu_cdn_path', $qiniu_cdn_path);


        return $next($request);
    }

}
