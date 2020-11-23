<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // register new LoginResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \ToTaa\Auth\Responses\LoginResponse::class
        );

        // register new TwofactorLoginResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\TwoFactorLoginResponse::class,
            \ToTaa\Auth\Responses\TwoFactorLoginResponse::class
        );

        // register new RegisterResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \ToTaa\Auth\Responses\RegisterResponse::class
        );

        // register new LoginResponse
        /*$this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \ToTaa\Auth\Responses\LoginResponse::class
        );*/

        Fortify::loginView(function () {
            return view('totaa::auth.login', ['urlback' => request("urlback")]);
        });

        Fortify::registerView(function () {
            return view('totaa::auth.register', ['urlback' => request("urlback")]);
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('totaa::auth.password-reset');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('totaa::auth.password-resetting', ['request' => $request]);
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)
            ->orWhere('phone', $request->email)
            ->first();

            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });
    }
}
