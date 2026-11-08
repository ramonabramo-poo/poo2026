<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Apunta cada petición en un fichero: método, ruta, código de respuesta y lo que tardó
class RegistroPeticiones implements Middleware
{
    private const ARCHIVO = __DIR__ . "/../../peticiones.log";

    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        $inicio = microtime(true);

        $respuesta = $siguiente($peticion);     // ← aquí trabajan los demás middleware y el controlador

        $milisegundos = round((microtime(true) - $inicio) * 1000, 1);
        $linea = sprintf("[%s] %s %s → %d (%s ms)\n", date("Y-m-d H:i:s"), $peticion->metodo, $peticion->ruta, $respuesta->codigo(), $milisegundos);
        file_put_contents(self::ARCHIVO, $linea, FILE_APPEND | LOCK_EX);

        return $respuesta;
    }
}
