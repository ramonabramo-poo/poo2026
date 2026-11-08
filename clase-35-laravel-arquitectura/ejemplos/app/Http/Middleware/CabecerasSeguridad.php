<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Un middleware que actúa DESPUÉS: deja pasar la petición y retoca la respuesta
class CabecerasSeguridad
{
    public function handle(Request $request, Closure $next): Response
    {
        $respuesta = $next($request);

        // Que nadie pueda meter nuestra web en un <iframe> (clickjacking)
        $respuesta->headers->set('X-Frame-Options', 'SAMEORIGIN');
        // Que el navegador no intente adivinar el tipo de los archivos
        $respuesta->headers->set('X-Content-Type-Options', 'nosniff');

        return $respuesta;
    }
}
