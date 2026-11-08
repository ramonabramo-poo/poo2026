<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Curso;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Ejercicio 05: el catálogo en tarjetas, con una vista parcial por curso
class CatalogoControlador extends Controlador
{
    public function tarjetas(Peticion $peticion): Respuesta
    {
        return $this->vista("cursos/tarjetas", ["titulo" => "Catálogo", "cursos" => Curso::todos("titulo")]);
    }
}
