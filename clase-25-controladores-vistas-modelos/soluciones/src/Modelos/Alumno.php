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

    // Ejercicio 09: las reglas del alumno, en el modelo
    public function errores(): array
    {
        $errores = [];
        if (mb_strlen($this->nombre) < 2) {
            $errores["nombre"] = "Escribe el nombre.";
        }
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $errores["email"] = "El email no es válido.";
        } elseif (Alumno::primero("email", $this->email) !== null) {
            $errores["email"] = "Ya hay un alumno con ese email.";
        }
        if (Curso::buscar($this->curso_id) === null) {
            $errores["curso_id"] = "Elige un curso.";
        }
        return $errores;
    }
}
