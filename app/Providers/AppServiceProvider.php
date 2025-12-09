<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
        // Share app_settings with all frontend views to prevent null access errors
        View::composer('frontend::*', function ($view) {
            try {
                // Get app settings from database with caching for performance
                $app_settings = cache()->remember('app_settings', 3600, function () {
                    return DB::table('app_settings')->first();
                });
                
                // Share with view
                $view->with('app_settings', $app_settings);
            } catch (\Exception $e) {
                // Fallback if table doesn't exist or error occurs
                $view->with('app_settings', null);
            }
        });
    }
}
