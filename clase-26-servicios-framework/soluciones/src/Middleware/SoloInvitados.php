<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\Auth;
use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Lo contrario de Autenticado: si YA has iniciado sesión, no tiene sentido ver el login o el registro
class SoloInvitados implements Middleware
{
    public function __construct(private Auth $auth)
    {
    }

    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        if ($this->auth->comprobar()) {
            return Respuesta::redirigir("/cursos");
        }
        return $siguiente($peticion);
    }
}
