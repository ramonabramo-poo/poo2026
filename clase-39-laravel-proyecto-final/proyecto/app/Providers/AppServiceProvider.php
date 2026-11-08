<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // En desarrollo, avisa con un error si cargamos relaciones sin with() (problema N+1)
        Model::preventLazyLoading(! app()->isProduction());

        // Los enlaces de la paginación, con un HTML sencillo que estilamos en academia.css
        Paginator::useBootstrapFour();

        // Una gate: un permiso con nombre que no depende de ningún modelo
        Gate::define('ver-panel', function (User $user) {
            return $user->esAdmin() || $user->esEditor();
        });
    }
}
