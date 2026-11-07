<?php
declare(strict_types=1);

namespace App\Controladores\Api;

use App\Modelos\Alumno;
use App\Modelos\Curso;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

class AlumnosApiControlador extends Controlador
{
    // GET /api/cursos/{id}/alumnos
    public function delCurso(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("No existe ningún curso con el id {$id}.");
        $alumnos = Alumno::donde("curso_id", $curso->id);

        return Respuesta::json([
            "curso" => $curso,
            "datos" => $alumnos,
            "meta" => ["total" => count($alumnos)],
        ]);
    }
}
