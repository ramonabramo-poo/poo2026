<?php

namespace App\Providers;

use App\Contracts\Notificador;
use App\Models\Categoria;
use App\Servicios\CalculadoraPrecios;
use App\Servicios\NotificadorCorreo;
use Illuminate\Support\Facades\Cache;
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

        // Ejercicio 01: cambiamos UNA línea y el formulario de contacto envía correos
        $this->app->bind(Notificador::class, NotificadorCorreo::class);
    }

    // boot(): lo que necesita que TODO esté ya registrado
    public function boot(): void
    {
        // Un "view composer": cada vez que se pinte el menú, recibe las categorías
        // Ejercicio 03: las categorías cambian muy poco, así que se guardan en la caché
        View::composer('partials.menu', function ($vista) {
            $vista->with('categoriasMenu', Cache::rememberForever('categorias-menu', function () {
                return Categoria::orderBy('nombre')->get();
            }));
        });
    }
}
