<?php
declare(strict_types=1);

namespace App\Modelos;

// Una ENTIDAD: un curso con sus datos y lo que sabe hacer.
// No sabe nada de la base de datos: de eso se encarga el repositorio.
class Curso
{
    public const IVA = 0.21;

    public function __construct(
        public ?int $id,              // null mientras el curso no se ha guardado
        public string $titulo,
        public int $horas,
        public float $precio,
        public int $plazas,
    ) {
    }

    // De una fila de la base de datos a un objeto
    public static function desdeFila(array $fila): Curso
    {
        return new Curso(
            (int) $fila["id"],
            $fila["titulo"],
            (int) $fila["horas"],
            (float) $fila["precio"],
            (int) $fila["plazas"],
        );
    }

    // De lo que llega por el formulario a un objeto (todavía sin validar)
    public static function desdeFormulario(array $post, ?int $id = null): Curso
    {
        return new Curso(
            $id,
            trim($post["titulo"] ?? ""),
            (int) ($post["horas"] ?? 0),
            (float) str_replace(",", ".", $post["precio"] ?? "0"),
            (int) ($post["plazas"] ?? 0),
        );
    }

    public static function vacio(): Curso
    {
        return new Curso(null, "", 20, 0, 20);
    }

    // Devuelve los errores con el nombre del campo como clave
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

    public function esValido(): bool
    {
        return count($this->errores()) === 0;
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
