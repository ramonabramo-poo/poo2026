<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Nucleo\Auth;
use App\Nucleo\Middleware;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Nucleo\Vista;

// Ejercicio 05: si existe el archivo "mantenimiento", la web se cierra… salvo para quien ha iniciado sesión
class ModoMantenimiento implements Middleware
{
    private const ARCHIVO = __DIR__ . "/../../mantenimiento";

    public function __construct(private Auth $auth)
    {
    }

    public function procesar(Peticion $peticion, callable $siguiente): Respuesta
    {
        $dejarPasar = !file_exists(self::ARCHIVO) || $this->auth->comprobar() || $peticion->ruta === "/login";

        if (!$dejarPasar) {
            return Respuesta::html(Vista::mostrar("paginas/mantenimiento", ["titulo" => "Volvemos enseguida"]), 503);
        }
        return $siguiente($peticion);
    }
}
