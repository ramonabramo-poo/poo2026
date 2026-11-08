<?php
declare(strict_types=1);

namespace App\Controladores;

use App\BaseDatos\Conexion;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;
use App\Repositorios\CursoRepositorio;

class CursosControlador
{
    private CursoRepositorio $cursos;

    public function __construct()
    {
        $this->cursos = new CursoRepositorio(Conexion::obtener());
    }

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

    public function ver(Peticion $peticion, int $id): Respuesta
    {
        $curso = $this->cursos->buscarPorId($id);

        if ($curso === null) {
            return Respuesta::html(vista("errores/404", ["titulo" => "Curso no encontrado"]), 404);
        }

        return Respuesta::html(vista("cursos/ver", ["titulo" => $curso->titulo, "curso" => $curso]));
    }

    // GET /cursos/{id}/precio → una respuesta de TEXTO, sin layout
    public function precio(Peticion $peticion, int $id): Respuesta
    {
        $curso = $this->cursos->buscarPorId($id);

        if ($curso === null) {
            return Respuesta::texto("Ese curso no existe.", 404);
        }

        return Respuesta::texto("El curso «{$curso->titulo}» cuesta " . euros($curso->precioConIva()) . " con IVA.");
    }
}
