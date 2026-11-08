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
            "seccion" => "cursos",
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

    // Ejercicio 06. GET /cursos/baratos?max=200
    public function baratos(): string
    {
        $maximo = (float) ($_GET["max"] ?? 200);
        $todos = $this->cursos->buscar("", 1, 1000);
        $baratos = array_values(array_filter($todos, fn(Curso $curso) => $curso->precioConIva() <= $maximo));

        return vista("cursos/index", [
            "titulo" => "Cursos por menos de " . euros($maximo),
            "cursos" => $baratos,
            "busqueda" => "",
            "pagina" => 1,
            "totalPaginas" => 1,
        ]);
    }

    // Ejercicio 08. GET /cursos/{id}/json: los mismos datos, pero para otro programa
    public function json(int $id): string
    {
        $curso = $this->cursos->buscarPorId($id);
        header("Content-Type: application/json; charset=utf-8");

        if ($curso === null) {
            http_response_code(404);
            return json_encode(["error" => "Curso no encontrado"]);
        }

        return json_encode([
            "id" => $curso->id,
            "titulo" => $curso->titulo,
            "horas" => $curso->horas,
            "precioConIva" => $curso->precioConIva(),
            "completo" => $curso->estaCompleto(),
        ], JSON_UNESCAPED_UNICODE);
    }

    // Ejercicio 10. GET /cursos/aleatorio: elige uno y REDIRIGE a su ficha
    public function aleatorio(): never
    {
        $todos = $this->cursos->buscar("", 1, 1000);
        $elegido = $todos[array_rand($todos)];

        header("Location: /cursos/{$elegido->id}");
        exit;
    }

    // GET /cursos/{id}
    public function ver(int $id): string
    {
        $curso = $this->cursos->buscarPorId($id);

        if ($curso === null) {
            http_response_code(404);
            return vista("errores/404", ["titulo" => "Curso no encontrado"]);
        }

        // Ejercicio 09: hasta tres cursos con un precio parecido (±30 %)
        $relacionados = array_filter(
            $this->cursos->buscar("", 1, 1000),
            fn(Curso $otro) => $otro->id !== $curso->id && abs($otro->precio - $curso->precio) <= $curso->precio * 0.3
        );

        return vista("cursos/ver", [
            "titulo" => $curso->titulo,
            "curso" => $curso,
            "relacionados" => array_slice($relacionados, 0, 3),
        ]);
    }
}
