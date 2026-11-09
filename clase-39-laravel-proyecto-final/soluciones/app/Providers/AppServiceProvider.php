<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $produccion = app()->isProduction();

        // Ejercicio 08: en desarrollo, Eloquent se vuelve "estricto" y avisa con un error si:
        // cargamos relaciones sin with() (N+1), leemos un atributo que no existe
        // o rellenamos uno que no está en Fillable (en vez de ignorarlo en silencio)
        Model::shouldBeStrict(! $produccion);

        // Ejercicio 08: en producción, prohibidos migrate:fresh, db:wipe y compañía
        DB::prohibitDestructiveCommands($produccion);

        // Ejercicio 08: en producción, todas las URL que genere Laravel con https://
        URL::forceHttps($produccion);

        // Los enlaces de la paginación, con un HTML sencillo que estilamos en academia.css
        Paginator::useBootstrapFour();

        // Una gate: un permiso con nombre que no depende de ningún modelo
        Gate::define('ver-panel', function (User $user) {
            return $user->esAdmin() || $user->esEditor();
        });
    }
}
