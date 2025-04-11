<?php

use App\Utils\Helpers\ResponseHelpers;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['errors' => $e->errors()],
                'Validation failed',
                422
            );
        });

        $exceptions->render(function (ModelNotFoundException $e) {
            $message = 'Entry for ' . str_replace('App\\', '', $e->getModel()) . ' not found';
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['errors' => $e->getMessage()],
                $message,
                404
            );
        });

        $exceptions->render(function (AuthenticationException $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['errors' => $e->getMessage()],
                "You are not authenticated",
                401
            );
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return ResponseHelpers::ConvertToJsonResponseWrapper(
                ['errors' => $e->getMessage()],
                "Page Not Found.",
                404
            );
        });
    })->create();
