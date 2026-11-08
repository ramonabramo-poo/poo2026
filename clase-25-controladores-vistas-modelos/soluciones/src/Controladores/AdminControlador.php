<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Ejercicio 07: hasta que tengamos login (clase 26), una «llave» en la URL
class AdminControlador extends Controlador
{
    public function index(Peticion $peticion): Respuesta
    {
        if ($peticion->consulta("llave") !== "academia") {
            $this->prohibido("Esta zona es solo para la dirección de la academia.");
        }

        return Respuesta::html("<h1>Panel de administración</h1>");
    }
}
