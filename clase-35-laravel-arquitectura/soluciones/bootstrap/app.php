<?php

use App\Http\Middleware\CabecerasSeguridad;
use App\Http\Middleware\ComprobarRol;
use App\Http\Middleware\RegistrarVisitas;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

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
        // Ejercicio 01: solo para las rutas de routes/web.php
        $middleware->appendToGroup('web', RegistrarVisitas::class);

        $middleware->alias([
            'rol' => ComprobarRol::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
