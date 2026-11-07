<?php
declare(strict_types=1);

namespace App\Controladores;

use App\BaseDatos\Conexion;
use App\Repositorios\CursoRepositorio;

// El CONTROLADOR: recibe la petición, pide los datos al modelo y elige la vista
class CursosControlador
{
    private CursoRepositorio $cursos;

    public function __construct()
    {
        $this->cursos = new CursoRepositorio(Conexion::obtener());
    }

    // GET /cursos
    public function index(): string
    {
        $busqueda = trim($_GET["q"] ?? "");
        $cursos = $this->cursos->buscar($busqueda, 1, 100);

        return vista("cursos/index", [
            "titulo" => "Cursos",
            "cursos" => $cursos,
            "busqueda" => $busqueda,
        ]);
    }

    // GET /cursos/{id}
    public function ver(int $id): string
    {
        $curso = $this->cursos->buscarPorId($id);

        if ($curso === null) {
            http_response_code(404);
            return vista("errores/404", ["titulo" => "Curso no encontrado"]);
        }

        return vista("cursos/ver", ["titulo" => $curso->titulo, "curso" => $curso]);
    }
}
