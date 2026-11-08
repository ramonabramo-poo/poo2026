<?php
declare(strict_types=1);

namespace App\Controladores;

use App\BaseDatos\Conexion;
use App\Modelos\Curso;
use App\Repositorios\CursoRepositorio;

class CursosControlador
{
    private CursoRepositorio $cursos;

    public function __construct()
    {
        $this->cursos = new CursoRepositorio(Conexion::obtener());
    }

    // GET /cursos (ahora con paginación: ?pagina=2)
    public function index(): string
    {
        $busqueda = trim($_GET["q"] ?? "");
        $pagina = max(1, (int) ($_GET["pagina"] ?? 1));
        $total = $this->cursos->contar($busqueda);
        $totalPaginas = max(1, (int) ceil($total / CURSOS_POR_PAGINA));
        $pagina = min($pagina, $totalPaginas);

        return vista("cursos/index", [
            "titulo" => "Cursos",
            "cursos" => $this->cursos->buscar($busqueda, $pagina, CURSOS_POR_PAGINA),
            "busqueda" => $busqueda,
            "pagina" => $pagina,
            "totalPaginas" => $totalPaginas,
        ]);
    }

    // GET /cursos/completos
    public function completos(): string
    {
        $todos = $this->cursos->buscar("", 1, 1000);
        $completos = array_values(array_filter($todos, fn(Curso $curso) => $curso->estaCompleto()));

        return vista("cursos/index", [
            "titulo" => "Cursos completos",
            "cursos" => $completos,
            "busqueda" => "",
            "pagina" => 1,
            "totalPaginas" => 1,
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
