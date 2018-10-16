<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register blade directives
        $this->bladeDirectives();

        $this->queryLog();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    private function bladeDirectives()
    {
        // Call to \Auth::guard('admin')->user()->hasRole
        \Blade::directive('adminrole', function($expression) {
            return "<?php if (\\Auth::guard('admin')->user()->hasRole{$expression}) :  ?>";
        });

        \Blade::directive('endadminrole', function($expression) {
            return "<?php endif; ?>";
        });

        // Call to \Auth::guard('admin')->user()->can
        \Blade::directive('adminpermission', function($expression) {
            return "<?php if (\\Auth::guard('admin')->user()->can{$expression}) : ?>";
        });

        \Blade::directive('endadminpermission', function($expression) {
            return "<?php endif; ?>";
        });

        // Call to \Auth::guard('admin')->user()->ability
        \Blade::directive('adminability', function($expression) {
            return "<?php if (\\Auth::guard('admin')->user()->ability{$expression}) : ?>";
        });

        \Blade::directive('endadminability', function($expression) {
            return "<?php endif; ?>";
        });
    }

    private function queryLog () {
        if (env('APP_ENV') === 'local') {
            DB::connection()->enableQueryLog();
        }
        if (env('APP_ENV') === 'local') {
            Event::listen('kernel.handled', function ($request, $response) {
                if ( $request->has('sql-debug') ) {
                    $queries = DB::getQueryLog();
                    Header("Content-Type:text/html;charset=utf-8");
                    dump($queries);
                }
            });
        }
    }
}
