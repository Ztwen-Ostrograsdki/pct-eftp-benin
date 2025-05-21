<?php

namespace App\Providers;

use App\Events\BlockedUserTryingToLoginEvent;
use App\Events\BlockUserEvent;
use App\Listeners\BlockedUserTryingToLoginListener;
use App\Listeners\BlockUserListener;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
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

        Gate::define('is_self_user', function($auth, $user_id){

            return $user_id == $auth->id;
        });


    }
}
