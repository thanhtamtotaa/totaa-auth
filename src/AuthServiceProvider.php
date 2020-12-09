<?php

namespace ToTaa\Auth;

use Illuminate\Support\ServiceProvider;
use Totaa\Auth\Http\Livewire\AuthLivewire;
use Livewire\Livewire;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (class_exists(Livewire::class)) {
            Livewire::component('totaa-auth::auth-livewire', AuthLivewire::class);
        }
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

        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        $this->publishes([
            __DIR__.'/../stubs/fortify.php' => config_path('fortify.php'),
        ], 'totaa-config');

        $this->publishes([
            __DIR__.'/../stubs/CreateNewUser.php' => app_path('Actions/Fortify/CreateNewUser.php'),
            __DIR__.'/../stubs/FortifyServiceProvider.php' => app_path('Providers/FortifyServiceProvider.php'),
            __DIR__.'/../stubs/layout-navbar.blade.php' => resource_path('views/layouts/includes/layout-navbar.blade.php'),
        ], 'totaa-support');

        /*
        |--------------------------------------------------------------------------
        | Seed Service Provider need on boot() method
        |--------------------------------------------------------------------------
        */
        $this->app->register(SeedServiceProvider::class);
    }
}
