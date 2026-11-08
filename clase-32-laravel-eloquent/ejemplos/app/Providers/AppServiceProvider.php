<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
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
    }
}
