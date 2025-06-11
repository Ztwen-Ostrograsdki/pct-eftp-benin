<?php

use App\Http\Middleware\AdminsOrSelfUserMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\MasterMiddleware;
use App\Http\Middleware\NotBlockedUserMiddleware;
use App\Http\Middleware\OnlyAdminsMiddleware;
use App\Http\Middleware\SelfUserMiddleware;
use App\Http\Middleware\UserConfirmedByAdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_master' => MasterMiddleware::class,
            'master' => MasterMiddleware::class,
            'self_user' => SelfUserMiddleware::class,
            'user.self' => SelfUserMiddleware::class,
            'user.confirmed.by.admin' => UserConfirmedByAdminMiddleware::class,
            'user.not.blocked' => NotBlockedUserMiddleware::class,
            'admin.or.master' => IsAdminMiddleware::class,
            'only.admins' => OnlyAdminsMiddleware::class,
            'self.or.admins' => AdminsOrSelfUserMiddleware::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
