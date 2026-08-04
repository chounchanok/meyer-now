<?php

namespace App\Providers;

use App\Core\KTBootstrap;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // // echo \Request::segment(1);exit;

        if (\Request::segment(1) == 'login' || \Request::segment(1) == '') {
            \Config::set('database.default', 'mil');
        }

        if (in_array(\Request::segment(1), array("mil", "mtl", "manager"))) {
            URL::defaults(['meyer' => \Request::segment(1)]);
            \Config::set('database.default', \Request::segment(1));
        }

        // Update defaultStringLength
        Builder::defaultStringLength(191);
        KTBootstrap::init();
    }
}
