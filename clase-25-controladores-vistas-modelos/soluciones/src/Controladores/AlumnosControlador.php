<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Alumno;
use App\Modelos\Curso;
use App\Nucleo\Controlador;
use App\Nucleo\Peticion;
use App\Nucleo\Respuesta;

class AlumnosControlador extends Controlador
{
    // Ejercicio 10: solo estas columnas se pueden usar para ordenar
    private const ORDENES = ["nombre" => "Nombre", "email" => "Email"];

    // GET /alumnos  (y /alumnos?orden=email)
    public function index(Peticion $peticion): Respuesta
    {
        $orden = $peticion->consulta("orden", "nombre");
        if (!array_key_exists($orden, self::ORDENES)) {
            $orden = "nombre";   // un valor raro no rompe la página: usamos el de siempre
        }

        return $this->vista("alumnos/index", [
            "titulo" => "Alumnos",
            "alumnos" => Alumno::todos($orden),
            "total" => Alumno::contar(),          // ejercicio 04
            "orden" => $orden,
            "ordenes" => self::ORDENES,
        ]);
    }

    // Ejercicio 09. GET /alumnos/crear
    public function crear(Peticion $peticion): Respuesta
    {
        return $this->formulario(new Alumno(), []);
    }

    // Ejercicio 09. POST /alumnos
    public function guardar(Peticion $peticion): Respuesta
    {
        $this->comprobarCsrf($peticion);
        $alumno = (new Alumno())->rellenar($peticion->todoElFormulario());
        $errores = $alumno->errores();

        if (count($errores) > 0) {
            return $this->formulario($alumno, $errores, 422);
        }

        $alumno->guardar();
        return $this->redirigir("/alumnos", "Alumno «{$alumno->nombre}» dado de alta.");
    }

    private function formulario(Alumno $alumno, array $errores, int $codigo = 200): Respuesta
    {
        return $this->vista("alumnos/crear", [
            "titulo" => "Nuevo alumno",
            "alumno" => $alumno,
            "errores" => $errores,
            "cursos" => Curso::todos("titulo"),
        ], $codigo);
    }
}
