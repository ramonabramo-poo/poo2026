<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\Entorno;
use App\Nucleo\HttpException;
use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Protege las rutas de escritura de la API: hace falta "Authorization: Bearer <token>"
class TokenApi implements Middleware
{
    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        $tokenEsperado = Entorno::obtener("API_TOKEN");
        $tokenRecibido = $peticion->tokenBearer();

        if ($tokenEsperado === "" || !hash_equals($tokenEsperado, $tokenRecibido)) {
            throw new HttpException(401, "Falta el token de la API o no es válido.");
        }
        return $siguiente($peticion);
    }
}
