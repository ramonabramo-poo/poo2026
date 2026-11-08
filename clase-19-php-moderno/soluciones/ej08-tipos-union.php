<?php
declare(strict_types=1);

// int|float: acepta los dos. ?string: un texto o null
function formatearPrecio(int|float $precio, ?string $moneda = null): string
{
    return number_format($precio, 2, ",", ".") . " " . ($moneda ?? "€");
}

// string|array: un id suelto o una lista de ids
function normalizarIds(string|array $ids): array
{
    if (is_string($ids)) {
        $ids = explode(",", $ids);
    }

    return array_map("intval", $ids);
}

echo formatearPrecio(10) . "<br>";
echo formatearPrecio(9.5, "USD") . "<br>";
echo implode(" · ", normalizarIds("4, 8,15")) . "<br>";
echo implode(" · ", normalizarIds(["16", "23", "42"]));
