<?php

namespace App\Providers;

use App\Contracts\ConversorMoneda;
use App\Contracts\Notificador;
use App\Models\Categoria;
use App\Servicios\CalculadoraPrecios;
use App\Servicios\ConversorFijo;
use App\Servicios\EstadisticasAcademia;
use App\Servicios\NotificadorArchivo;
use App\Servicios\NotificadorLog;
use App\Servicios\NotificadorMultiple;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AcademiaServiceProvider extends ServiceProvider
{
    // register(): SOLO enseñar al contenedor cómo crear cada servicio
    public function register(): void
    {
        // singleton: el mismo objeto para toda la petición
        $this->app->singleton(CalculadoraPrecios::class, function () {
            return new CalculadoraPrecios(
                iva: config('academia.iva'),
                descuentoMaximo: config('academia.descuento_maximo'),
            );
        });

        // Ejercicio 02: la implementación depende de la configuración
        // Ejercicio 08: 'ambos' combina las dos
        $this->app->bind(Notificador::class, function () {
            return match (config('academia.notificador')) {
                'archivo' => new NotificadorArchivo(),
                'ambos' => new NotificadorMultiple([new NotificadorLog(), new NotificadorArchivo()]),
                default => new NotificadorLog(),
            };
        });

        // Ejercicio 04: una sola instancia para toda la petición
        $this->app->singleton(EstadisticasAcademia::class);

        // Ejercicio 06
        $this->app->singleton(ConversorMoneda::class, function () {
            return new ConversorFijo(config('academia.cambios'));
        });
    }

    // boot(): lo que necesita que TODO esté ya registrado
    public function boot(): void
    {
        // Un "view composer": cada vez que se pinte el menú, recibe las categorías
        View::composer('partials.menu', function ($vista) {
            $vista->with('categoriasMenu', Categoria::orderBy('nombre')->get());
        });

        // Ejercicio 07: View::share comparte un dato con TODAS las vistas
        View::share('academia', config('academia'));

        // Ejercicio 09: un límite con nombre para el formulario de contacto:
        // 3 mensajes por minuto por cada IP. Se usa en la ruta con ->middleware('throttle:contacto')
        RateLimiter::for('contacto', function (Request $request) {
            return Limit::perMinute(3)
                ->by($request->ip())
                ->response(function () {
                    return back()->withInput()->with('error', 'Has enviado demasiados mensajes. Espera un minuto.');
                });
        });
    }
}
