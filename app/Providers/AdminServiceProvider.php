<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Add Blade directives for admin roles
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->is_admin;
        });
        
        // Register route pattern for admin routes
        Route::pattern('adminId', '[0-9]+');
    }
} 