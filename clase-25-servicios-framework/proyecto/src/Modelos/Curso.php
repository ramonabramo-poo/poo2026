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

    // Las reglas de validación, en el propio modelo para reutilizarlas al crear y al editar
    public static function reglas(): array
    {
        return [
            "titulo" => "obligatorio|min:3|max:120",
            "horas" => "obligatorio|entero|min:1|max:1000",
            "precio" => "obligatorio|numero|min:0|max:99999",
            "plazas" => "obligatorio|entero|min:0|max:500",
        ];
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
