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
        // Ejercicio 05: ?pagina=2, con 1 como mínimo aunque escriban ?pagina=-5 o ?pagina=abc
        $pagina = $peticion->consultaEntero("pagina", 1, minimo: 1);
        $cursos = $this->cursos->buscar($busqueda, $pagina, CURSOS_POR_PAGINA);

        return Respuesta::html(vista("cursos/index", [
            "titulo" => "Cursos",
            "cursos" => $cursos,
            "busqueda" => $busqueda,
        ]))->conCabecera("X-Total-Cursos", (string) $this->cursos->contar($busqueda));   // ejercicio 07
    }

    // Ejercicio 06: /buscar/php → /cursos?q=php
    public function buscar(Peticion $peticion, string $texto): Respuesta
    {
        return Respuesta::redirigir("/cursos?q=" . urlencode($texto));
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

    // Ejercicio 04
    public function json(Peticion $peticion, int $id): Respuesta
    {
        $curso = $this->cursos->buscarPorId($id);

        if ($curso === null) {
            return Respuesta::json(["error" => "Curso no encontrado"], 404);
        }

        return Respuesta::json([
            "id" => $curso->id,
            "titulo" => $curso->titulo,
            "precioConIva" => $curso->precioConIva(),
            "completo" => $curso->estaCompleto(),
        ]);
    }

    // Ejercicio 08
    public function csv(Peticion $peticion): Respuesta
    {
        $lineas = ["Título;Horas;Precio con IVA"];
        foreach ($this->cursos->buscar("", 1, 1000) as $curso) {
            $lineas[] = "{$curso->titulo};{$curso->horas};" . number_format($curso->precioConIva(), 2, ",", "");
        }

        return Respuesta::descarga("\xEF\xBB\xBF" . implode("\n", $lineas), "cursos.csv");
    }
}
