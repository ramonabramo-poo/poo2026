<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Alumno;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

class AlumnosControlador extends Controlador
{
    // GET /alumnos
    public function index(Peticion $peticion): Respuesta
    {
        return $this->vista("alumnos/index", ["titulo" => "Alumnos", "alumnos" => Alumno::todos("nombre")]);
    }
}
