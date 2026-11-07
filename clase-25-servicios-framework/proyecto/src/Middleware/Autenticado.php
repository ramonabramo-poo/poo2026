<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\Auth;
use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Nucleo\Sesion;

// El GUARDIÁN de la clase 12, convertido en middleware: sin sesión, al login
class Autenticado implements Middleware
{
    // El contenedor le da el servicio Auth automáticamente (autowiring)
    public function __construct(private Auth $auth)
    {
    }

    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        if (!$this->auth->comprobar()) {
            Sesion::guardarMensaje("Inicia sesión para gestionar los cursos.", "error");
            return Respuesta::redirigir("/login");
        }
        return $siguiente($peticion);
    }
}
