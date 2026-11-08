<?php
declare(strict_types=1);

namespace App\Modelos;

use App\Nucleo\Modelo;
use JsonSerializable;

class Alumno extends Modelo implements JsonSerializable
{
    protected static string $tabla = "alumnos";
    protected static array $columnas = [
        "nombre" => "string",
        "email" => "string",
        "curso_id" => "int",
    ];

    public string $nombre = "";
    public string $email = "";
    public int $curso_id = 0;

    public function jsonSerialize(): array
    {
        return ["id" => $this->id, "nombre" => $this->nombre, "email" => $this->email, "curso_id" => $this->curso_id];
    }
}
