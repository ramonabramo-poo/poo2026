<?php
declare(strict_types=1);

namespace App\Modelos;

use App\Nucleo\Modelo;

class Alumno extends Modelo
{
    protected static string $tabla = "alumnos";
    protected static array $columnas = [
        "nombre" => "string",
        "email" => "string",
        "curso_id" => "int",
    ];

    public string $nombre = "";
    public string $email = "";
    public int $curso_id = 0;   // se llama como la columna para que rellenar() la encuentre

    // RELACIÓN: un alumno PERTENECE A un curso (en Laravel: belongsTo)
    public function curso(): ?Curso
    {
        return Curso::buscar($this->curso_id);
    }
}
