<?php

namespace ToTaa\Auth;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'totaa');

        $this->publishes([
            __DIR__.'/../stubs/fortify.php' => config_path('fortify.php'),
        ], 'totaa-config');

        $this->publishes([
            __DIR__.'/../stubs/CreateNewUser.php' => app_path('Actions/Fortify/CreateNewUser.php'),
            __DIR__.'/../stubs/FortifyServiceProvider.php' => app_path('Providers/FortifyServiceProvider.php'),
            __DIR__.'/../stubs/layout-navbar.blade.php' => app_path('resources/views/layouts/includes/layout-navbar.blade.php'),
        ], 'totaa-support');
    }
}
