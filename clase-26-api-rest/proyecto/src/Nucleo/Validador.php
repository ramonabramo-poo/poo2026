<?php
declare(strict_types=1);

namespace App\Nucleo;

// Valida un array de datos con reglas escritas como texto: "obligatorio|min:3|max:120"
class Validador
{
    private array $errores = [];

    public function __construct(private array $datos, private array $reglas)
    {
        foreach ($this->reglas as $campo => $reglasDelCampo) {
            $this->validarCampo($campo, explode("|", $reglasDelCampo));
        }
    }

    public function falla(): bool
    {
        return count($this->errores) > 0;
    }

    public function errores(): array
    {
        return $this->errores;
    }

    // Solo los campos que tienen reglas: nada de datos "colados" en el formulario
    public function validados(): array
    {
        return array_intersect_key($this->datos, $this->reglas);
    }

    private function validarCampo(string $campo, array $reglas): void
    {
        $valor = trim((string) ($this->datos[$campo] ?? ""));
        $esNumerico = in_array("entero", $reglas, true) || in_array("numero", $reglas, true);

        foreach ($reglas as $regla) {
            [$nombre, $parametro] = array_pad(explode(":", $regla, 2), 2, "");
            $error = $this->comprobar($nombre, $parametro, $valor, $esNumerico);
            if ($error !== null) {
                $this->errores[$campo] = ucfirst($error) . ".";
                return;   // un error por campo es suficiente
            }
        }
    }

    private function comprobar(string $regla, string $parametro, string $valor, bool $esNumerico): ?string
    {
        if ($regla !== "obligatorio" && $valor === "") {
            return null;   // las demás reglas no se aplican a un campo vacío y opcional
        }

        return match ($regla) {
            "obligatorio" => $valor === "" ? "es obligatorio" : null,
            "entero" => filter_var($valor, FILTER_VALIDATE_INT) === false ? "debe ser un número entero" : null,
            "numero" => !is_numeric(str_replace(",", ".", $valor)) ? "debe ser un número" : null,
            "email" => filter_var($valor, FILTER_VALIDATE_EMAIL) === false ? "debe ser un email válido" : null,
            "min" => $esNumerico
                ? ((float) $valor < (float) $parametro ? "debe ser como mínimo {$parametro}" : null)
                : (mb_strlen($valor) < (int) $parametro ? "debe tener al menos {$parametro} caracteres" : null),
            "max" => $esNumerico
                ? ((float) $valor > (float) $parametro ? "debe ser como máximo {$parametro}" : null)
                : (mb_strlen($valor) > (int) $parametro ? "no puede pasar de {$parametro} caracteres" : null),
            default => throw new \InvalidArgumentException("Regla de validación desconocida: {$regla}"),
        };
    }
}
