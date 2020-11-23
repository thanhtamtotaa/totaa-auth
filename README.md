Installation
To get started, install using Composer:

composer require totaa/totaa-auth

Next, publish Fortify's resources:

php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"

The vendor:publish command discussed above will also publish the app/Providers/FortifyServiceProvider file. You should ensure this file is registered within the providers array of your app configuration file.

Next, publish Auth's resources:

php artisan vendor:publish --force --provider="ToTaa\Auth\AuthServiceProvider"
