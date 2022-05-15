<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->singleton('lang', function()
        {
            if(auth('admins')->user())
            {
                if(empty(auth('admins')->user()->lang))
                {
                    session()->put('lang', 'ar');
                    return 'ar';
                }
                else
                {
                    return auth('admins')->user()->lang;
                }
            }
            else
            {
                if (session()->has('lang'))
                {
                    return session()->get('lang');
                }
                else
                {
                    session()->put('lang', 'ar');
                    return 'ar';
                }
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }
}
