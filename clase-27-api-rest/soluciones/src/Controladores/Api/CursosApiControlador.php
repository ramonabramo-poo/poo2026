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
    // Ejercicio 05: columnas por las que se puede ordenar (con "-" delante, al revés)
    private const ORDENES = ["titulo", "precio", "horas", "plazas"];

    // GET /api/cursos?q=php&pagina=2&por_pagina=10&orden=-precio
    public function index(Peticion $peticion): Respuesta
    {
        $busqueda = mb_strtolower($peticion->consulta("q"));
        // Ejercicio 08: el cliente elige cuántos por página, pero entre 1 y 20
        $porPagina = min(20, max(1, (int) $peticion->consulta("por_pagina", "5")));

        $orden = $peticion->consulta("orden", "titulo");
        $columna = ltrim($orden, "-");
        if (!in_array($columna, self::ORDENES, true)) {
            throw new HttpException(400, "No se puede ordenar por «{$columna}». Opciones: " . implode(", ", self::ORDENES));
        }

        $cursos = array_values(array_filter(
            Curso::todos($columna),
            fn(Curso $curso) => $busqueda === "" || str_contains(mb_strtolower($curso->titulo), $busqueda)
        ));
        if (str_starts_with($orden, "-")) {
            $cursos = array_reverse($cursos);
        }

        $total = count($cursos);
        $paginas = max(1, (int) ceil($total / $porPagina));
        $pagina = min(max(1, (int) $peticion->consulta("pagina", "1")), $paginas);

        return Respuesta::json([
            "datos" => array_slice($cursos, ($pagina - 1) * $porPagina, $porPagina),
            "meta" => ["pagina" => $pagina, "por_pagina" => $porPagina, "total" => $total, "paginas" => $paginas, "orden" => $orden],
        ]);
    }

    // Ejercicio 04. GET /api/estadisticas
    public function estadisticas(Peticion $peticion): Respuesta
    {
        $cursos = Curso::todos();
        $completos = array_filter($cursos, fn(Curso $curso) => $curso->estaCompleto());
        $precios = array_map(fn(Curso $curso) => $curso->precio, $cursos);

        return Respuesta::json(["datos" => [
            "cursos" => count($cursos),
            "completos" => count($completos),
            "precio_medio" => count($precios) > 0 ? round(array_sum($precios) / count($precios), 2) : 0,
        ]]);
    }

    // Ejercicio 06. GET /api/cursos/{id}/precio?descuento=10
    public function precio(Peticion $peticion, int $id): Respuesta
    {
        $curso = Curso::buscar($id) ?? $this->noEncontrado("No existe ningún curso con el id {$id}.");
        $descuento = $peticion->consulta("descuento", "0");

        if (filter_var($descuento, FILTER_VALIDATE_INT) === false || (int) $descuento < 0 || (int) $descuento > 50) {
            return Respuesta::json(["error" => "El descuento debe ser un número entero entre 0 y 50."], 422);
        }

        $base = round($curso->precio * (100 - (int) $descuento) / 100, 2);

        return Respuesta::json(["datos" => [
            "curso" => $curso->titulo,
            "precio" => $curso->precio,
            "descuento" => (int) $descuento,
            "base" => $base,
            "total_con_iva" => round($base * (1 + Curso::IVA), 2),
        ]]);
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
