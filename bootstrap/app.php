<?php

use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\CastQueryParams;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        DatabaseServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'api.key' => ApiKeyMiddleware::class,
            'cast.query' => CastQueryParams::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Resource not found',
            ], 404);
        });

        $exceptions->render(function (InvalidArgumentException $e, Request $request) {
            return response()->json([
                'error' => 'Invalid Argument',
                'message' => $e->getMessage(),
            ], 400);
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            return response()->json([
                'error' => 'Database Error',
                'message' => $e->getMessage(),
            ], 500);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
            ], 500);
        });
    })
    ->create();
