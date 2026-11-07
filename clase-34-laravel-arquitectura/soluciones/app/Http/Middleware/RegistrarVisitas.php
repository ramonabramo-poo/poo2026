<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

// Ejercicio 01: apunta en el log cada página visitada, quién la visita y cuánto ha tardado
class RegistrarVisitas
{
    public function handle(Request $request, Closure $next): Response
    {
        $inicio = microtime(true);

        $respuesta = $next($request);

        $milisegundos = round((microtime(true) - $inicio) * 1000);
        $usuario = $request->user()?->email ?? 'invitado';

        Log::info("{$request->method()} {$request->getRequestUri()} → {$respuesta->getStatusCode()} ({$milisegundos} ms, {$usuario})");

        return $respuesta;
    }
}
