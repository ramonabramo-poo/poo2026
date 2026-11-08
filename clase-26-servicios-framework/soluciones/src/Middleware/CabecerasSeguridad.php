<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Ejercicio 06: este middleware trabaja DESPUÉS: deja pasar y retoca la respuesta
class CabecerasSeguridad implements Middleware
{
    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        $respuesta = $siguiente($peticion);

        return $respuesta
            ->conCabecera("X-Frame-Options", "SAMEORIGIN")
            ->conCabecera("X-Content-Type-Options", "nosniff");
    }
}
