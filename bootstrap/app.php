<?php

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\AllowAllMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(

    web: [
        __DIR__ . '/../routes/web.php',
        __DIR__ . '/../routes/candidate.php', // أضف هذا السطر
    ],
        commands: __DIR__.'/../routes/console.php',

        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // Bypass all authz/authn checks
            'auth' => AllowAllMiddleware::class,
            'verified' => AllowAllMiddleware::class,
            'role' => AllowAllMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
