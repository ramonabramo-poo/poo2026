<?php
declare(strict_types=1);

namespace App\Controladores\Api;

use App\Modelos\Curso;
use App\Nucleo\Controlador;
use App\Nucleo\HttpException;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// La API REST de cursos: las mismas operaciones que la web, pero hablando JSON
class CursosApiControlador extends Controlador
{
    // GET /api/cursos?q=php&pagina=2
    public function index(Peticion $peticion): Respuesta
    {
        $busqueda = $peticion->consulta("q");
        $porPagina = 5;
        $total = Curso::contarDonde("titulo", $busqueda);
        $paginas = max(1, (int) ceil($total / $porPagina));
        $pagina = min(max(1, (int) $peticion->consulta("pagina", "1")), $paginas);

        return Respuesta::json([
            "datos" => Curso::paginaDonde("titulo", $busqueda, $pagina, $porPagina),
            "meta" => ["pagina" => $pagina, "por_pagina" => $porPagina, "total" => $total, "paginas" => $paginas],
        ]);
    }

    // GET /api/cursos/{id}
    public function ver(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("No existe ningún curso con el id {$id}.");

        return Respuesta::json(["datos" => $curso]);
    }

    // POST /api/cursos   (cuerpo JSON)
    public function guardar(Peticion $peticion): Respuesta
    {
        $datos = $peticion->validar(Curso::reglas());

        $curso = (new Curso())->rellenar($datos);
        $curso->guardar();

        // 201 Created + la dirección del recurso nuevo en la cabecera Location
        return Respuesta::json(["datos" => $curso], 201, ["Location" => "/api/cursos/{$curso->id}"]);
    }

    // PUT /api/cursos/{id}   (cuerpo JSON)
    public function actualizar(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("No existe ningún curso con el id {$id}.");
        $datos = $peticion->validar(Curso::reglas());

        $curso->rellenar($datos)->guardar();

        return Respuesta::json(["datos" => $curso]);
    }

    // DELETE /api/cursos/{id}
    public function borrar(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("No existe ningún curso con el id {$id}.");

        try {
            $curso->borrar();
        } catch (\PDOException $e) {
            if (($e->errorInfo[1] ?? 0) !== 1451) {
                throw $e;
            }
            throw new HttpException(409, "No se puede borrar: el curso tiene alumnos.");   // 409 Conflict
        }

        return Respuesta::vacia();
    }
}
