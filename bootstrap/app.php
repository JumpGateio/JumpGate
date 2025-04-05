<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use JumpGate\Menu\Middleware\MenuMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web     : __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health  : '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        if (env('AUTH_SOCIAL_ONLY')) {
            $middleware->redirectGuestsTo(fn() => route('auth.social.login'));
        } else {
            $middleware->redirectGuestsTo(fn() => route('auth.login'));
        }

        $middleware->encryptCookies(except: ['appearance']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
            MenuMiddleware::class,
        ]);

        $middleware->alias([
            'active' => MenuMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
