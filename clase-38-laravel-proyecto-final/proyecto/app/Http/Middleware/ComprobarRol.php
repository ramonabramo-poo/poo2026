<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Uso en las rutas: ->middleware('rol:admin')  o  ->middleware('rol:admin,editor')
class ComprobarRol
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $usuario = $request->user();

        if ($usuario === null || ! in_array($usuario->rol->value, $roles, true)) {
            abort(403);
        }

        // Todo en orden: que la petición siga hacia el controlador
        return $next($request);
    }
}
