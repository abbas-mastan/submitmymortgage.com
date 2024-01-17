<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
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
        // Model::preventLazyLoading(! $this->app->isProduction());
        //change the default length of string column
        Schema::defaultStringLength(191);

        View()->composer('*', function ($view) {
            if (Auth::check()) $view->with('currentrole', Auth::user()->role);
            else $view->with('currentrole', null);
            $view->with('superadminrole', config('constants.SUPER_ADMIN_ROLE'));
        });
        

    }
}
