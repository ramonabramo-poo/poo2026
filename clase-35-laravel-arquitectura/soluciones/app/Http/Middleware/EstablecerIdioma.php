<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

// Ejercicio 05: un middleware que actúa ANTES: prepara la aplicación y deja pasar la petición
class EstablecerIdioma
{
    public function handle(Request $request, Closure $next): Response
    {
        $idioma = $request->session()->get('idioma', config('app.locale'));

        // A partir de aquí, __(), los mensajes de validación, etc., salen en ese idioma
        App::setLocale($idioma);

        return $next($request);
    }
}
