<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Nucleo\Sesion;

// Ejercicio 10: como mucho 5 intentos de login por minuto
class LimiteIntentos implements Middleware
{
    private const MAXIMO = 5;
    private const SEGUNDOS = 60;

    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        if ($peticion->metodo !== "POST") {
            return $siguiente($peticion);
        }

        // Nos quedamos con los intentos del último minuto
        $intentos = array_filter(
            Sesion::obtener("intentos_login", []),
            fn(int $momento) => $momento > time() - self::SEGUNDOS
        );

        if (count($intentos) >= self::MAXIMO) {
            return Respuesta::texto("Demasiados intentos. Espera un minuto y vuelve a probar.", 429);
        }

        $intentos[] = time();
        Sesion::guardar("intentos_login", array_values($intentos));

        return $siguiente($peticion);
    }
}
