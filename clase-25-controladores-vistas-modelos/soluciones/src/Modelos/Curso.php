<?php
declare(strict_types=1);

namespace App\Modelos;

use App\Nucleo\Modelo;

// Gracias al modelo base, Curso solo declara su tabla, sus columnas y SU lógica
class Curso extends Modelo
{
    public const IVA = 0.21;

    protected static string $tabla = "cursos";
    protected static array $columnas = [
        "titulo" => "string",
        "horas" => "int",
        "precio" => "float",
        "plazas" => "int",
    ];

    public string $titulo = "";
    public int $horas = 20;
    public float $precio = 0;
    public int $plazas = 20;

    public function errores(): array
    {
        $errores = [];
        if (mb_strlen($this->titulo) < 3 || mb_strlen($this->titulo) > 120) {
            $errores["titulo"] = "El título debe tener entre 3 y 120 caracteres.";
        }
        if ($this->horas < 1 || $this->horas > 1000) {
            $errores["horas"] = "Las horas deben estar entre 1 y 1000.";
        }
        if ($this->precio < 0 || $this->precio > 99999) {
            $errores["precio"] = "El precio no es válido.";
        }
        if ($this->plazas < 0 || $this->plazas > 500) {
            $errores["plazas"] = "Las plazas deben estar entre 0 y 500.";
        }
        return $errores;
    }

    // RELACIÓN: un curso TIENE MUCHOS alumnos (en Laravel: hasMany)
    /** @return Alumno[] */
    public function alumnos(): array
    {
        return Alumno::donde("curso_id", $this->id);
    }

    public function precioConIva(): float
    {
        return round($this->precio * (1 + self::IVA), 2);
    }

    public function estaCompleto(): bool
    {
        return $this->plazas === 0;
    }
}
