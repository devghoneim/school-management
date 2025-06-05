<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    // public const HOME = '/dashboard';
    public const STUDENT = '/student/dashboard';
    public const TEACHER = '/dashboard';
    public const PARENT = '/dashboard';

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
