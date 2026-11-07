<?php
declare(strict_types=1);

namespace App\Controladores;

use App\BaseDatos\Conexion;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Repositorios\CursoRepositorio;

// Ahora cada acción RECIBE una Peticion y DEVUELVE una Respuesta
class CursosControlador
{
    private CursoRepositorio $cursos;

    public function __construct()
    {
        $this->cursos = new CursoRepositorio(Conexion::obtener());
    }

    // GET /cursos
    public function index(Peticion $peticion): Respuesta
    {
        $busqueda = $peticion->consulta("q");
        $cursos = $this->cursos->buscar($busqueda, 1, 100);

        return Respuesta::html(vista("cursos/index", [
            "titulo" => "Cursos",
            "cursos" => $cursos,
            "busqueda" => $busqueda,
        ]));
    }

    // GET /cursos/{id}
    public function ver(Peticion $peticion, int $id): Respuesta
    {
        $curso = $this->cursos->buscarPorId($id);

        if ($curso === null) {
            return Respuesta::html(vista("errores/404", ["titulo" => "Curso no encontrado"]), 404);
        }

        return Respuesta::html(vista("cursos/ver", ["titulo" => $curso->titulo, "curso" => $curso]));
    }
}
