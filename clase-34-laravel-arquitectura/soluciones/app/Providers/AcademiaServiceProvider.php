<?php

namespace App\Providers;

use App\Contracts\Notificador;
use App\Models\Categoria;
use App\Servicios\CalculadoraPrecios;
use App\Servicios\NotificadorArchivo;
use App\Servicios\NotificadorLog;
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
        $this->app->bind(Notificador::class, function () {
            return match (config('academia.notificador')) {
                'archivo' => new NotificadorArchivo(),
                default => new NotificadorLog(),
            };
        });
    }

    // boot(): lo que necesita que TODO esté ya registrado
    public function boot(): void
    {
        // Un "view composer": cada vez que se pinte el menú, recibe las categorías
        View::composer('partials.menu', function ($vista) {
            $vista->with('categoriasMenu', Categoria::orderBy('nombre')->get());
        });
    }
}
