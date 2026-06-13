<?php

use App\Http\Middleware\CheckApiToken;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureApprovedVendor;
use App\Http\Middleware\EnsureVendor;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web.php',
            __DIR__ . '/../routes/dashboard.php',
        ],
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Trust Render's load balancer so asset() / url() produce https:// URLs.
        // Render forwards X-Forwarded-Proto: https; without this the app sees
        // plain HTTP and generates mixed-content asset URLs the browser blocks.
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'abilities'       => CheckAbilities::class,
            'ability'         => CheckForAnyAbility::class,
            'admin'           => EnsureAdmin::class,
            'vendor'          => EnsureVendor::class,
            'vendor.approved' => EnsureApprovedVendor::class,
        ]);
        $middleware->api(prepend: [
            CheckApiToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
