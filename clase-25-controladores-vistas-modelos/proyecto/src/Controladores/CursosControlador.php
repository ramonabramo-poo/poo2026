<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Curso;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

// Un controlador de RECURSO: las siete acciones típicas de un CRUD
class CursosControlador extends Controlador
{
    // GET /cursos
    public function index(Peticion $peticion): Respuesta
    {
        $busqueda = $peticion->consulta("q");
        $total = Curso::contarDonde("titulo", $busqueda);
        $totalPaginas = max(1, (int) ceil($total / CURSOS_POR_PAGINA));
        $pagina = min(max(1, (int) $peticion->consulta("pagina", "1")), $totalPaginas);

        return $this->vista("cursos/index", [
            "titulo" => "Cursos",
            "cursos" => Curso::paginaDonde("titulo", $busqueda, $pagina, CURSOS_POR_PAGINA),
            "busqueda" => $busqueda,
            "total" => $total,
            "pagina" => $pagina,
            "totalPaginas" => $totalPaginas,
        ]);
    }

    // GET /cursos/{id}
    public function ver(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("Ese curso no existe.");

        return $this->vista("cursos/ver", ["titulo" => $curso->titulo, "curso" => $curso]);
    }

    // GET /cursos/crear
    public function crear(Peticion $peticion): Respuesta
    {
        return $this->vista("cursos/crear", ["titulo" => "Nuevo curso", "curso" => new Curso(), "errores" => []]);
    }

    // POST /cursos
    public function guardar(Peticion $peticion): Respuesta
    {
        $this->comprobarCsrf($peticion);
        $curso = (new Curso())->rellenar($peticion->todoElFormulario());
        $errores = $curso->errores();

        if (count($errores) > 0) {
            return $this->vista("cursos/crear", ["titulo" => "Nuevo curso", "curso" => $curso, "errores" => $errores], 422);
        }

        $curso->guardar();
        return $this->redirigir("/cursos/{$curso->id}", "Curso «{$curso->titulo}» creado.");
    }

    // GET /cursos/{id}/editar
    public function editar(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("Ese curso no existe.");

        return $this->vista("cursos/editar", ["titulo" => "Editar curso", "curso" => $curso, "errores" => []]);
    }

    // POST /cursos/{id}
    public function actualizar(Peticion $peticion, int $id): Respuesta
    {
        $this->comprobarCsrf($peticion);
        $curso = Curso::buscar($id) ?? $this->noEncontrado("Ese curso no existe.");
        $curso->rellenar($peticion->todoElFormulario());
        $errores = $curso->errores();

        if (count($errores) > 0) {
            return $this->vista("cursos/editar", ["titulo" => "Editar curso", "curso" => $curso, "errores" => $errores], 422);
        }

        $curso->guardar();
        return $this->redirigir("/cursos/{$curso->id}", "Curso «{$curso->titulo}» actualizado.");
    }

    // POST /cursos/{id}/borrar
    public function borrar(Peticion $peticion, int $id): Respuesta
    {
        $this->comprobarCsrf($peticion);
        $curso = Curso::buscar($id) ?? $this->noEncontrado("Ese curso no existe.");

        try {
            $curso->borrar();
        } catch (\PDOException $e) {
            if (($e->errorInfo[1] ?? 0) !== 1451) {
                throw $e;
            }
            return $this->redirigir("/cursos/{$id}", "No se puede borrar: el curso tiene alumnos.", "error");
        }

        return $this->redirigir("/cursos", "Curso «{$curso->titulo}» borrado.");
    }
}
