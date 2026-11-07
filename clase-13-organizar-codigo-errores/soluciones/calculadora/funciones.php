<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

function calcular(float $a, float $b, string $operacion): float
{
    return match ($operacion) {
        "+" => $a + $b,
        "-" => $a - $b,
        "*" => $a * $b,
        "/" => $b == 0.0
            ? throw new DivisionByZeroError("No se puede dividir entre cero.")
            : $a / $b,
        default => throw new InvalidArgumentException("Operación desconocida: {$operacion}"),
    };
}
