<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Permission;
use App\Helpers\Notification;

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
        view()->composer('*',function($view){
            $view->with('permissionAccess',Permission::access())->with('currentRoute',request()->route())->with('notification',Notification::get());
        });
    }
}
