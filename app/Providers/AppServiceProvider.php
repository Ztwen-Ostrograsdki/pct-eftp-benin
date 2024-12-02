<?php

namespace App\Providers;

use App\Events\BlockedUserTryingToLoginEvent;
use App\Events\BlockUserEvent;
use App\Listeners\BlockedUserTryingToLoginListener;
use App\Listeners\BlockUserListener;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once app_path('Helpers/RobotsHelpers.php');


        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
            ->locales(['en','fr', 'af', 'ar', '']); // also accepts a closure
        });
 
    }
}
