<?php

use App\Http\Middleware\CabecerasSeguridad;
use App\Http\Middleware\ComprobarRol;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Para todas las peticiones
        $middleware->append(CabecerasSeguridad::class);

        // Un nombre corto para usarlo en las rutas
        $middleware->alias([
            'rol' => ComprobarRol::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Los errores HTTP de la API (403, 404, 405, 429...), con mensajes en español
        $exceptions->render(function (HttpException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;  // en la web, las páginas de error de siempre
            }

            $mensaje = match ($e->getStatusCode()) {
                403 => 'No tienes permiso para hacer esto.',
                404 => 'Recurso no encontrado.',
                405 => 'Método no permitido en esta dirección.',
                429 => 'Demasiadas peticiones. Espera un poco.',
                default => $e->getMessage(),
            };

            return response()->json(['mensaje' => $mensaje], $e->getStatusCode(), $e->getHeaders());
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['mensaje' => 'Necesitas un token válido.'], 401);
            }
        });
    })->create();
