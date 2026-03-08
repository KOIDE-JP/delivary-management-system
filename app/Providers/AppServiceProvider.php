<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('permission', function ($permission) {
            if(auth(auth()->getDefaultDriver())->user()->role_id==1)
            {
                return true;
            }
            return auth(auth()->getDefaultDriver())->user()->hasPermission($permission);
        });
    }
}
