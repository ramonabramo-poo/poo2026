<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\HttpException;
use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Nucleo\Sesion;

// En TODAS las peticiones POST comprueba el token CSRF. Los controladores ya no se ocupan de ello.
class VerificarCsrf implements Middleware
{
    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        // La API no usa cookies de sesión sino un token propio: el CSRF no tiene sentido allí
        if ($peticion->esApi()) {
            return $siguiente($peticion);
        }
        if ($peticion->metodo === "POST" && !Sesion::csrfValido($peticion->formulario("csrf"))) {
            throw new HttpException(403, "El formulario ha caducado o no es válido. Volved a intentarlo.");
        }
        return $siguiente($peticion);
    }
}
