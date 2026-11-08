<?php
declare(strict_types=1);

// Funciones sueltas que usan todas las páginas.
// Composer las carga gracias a "files" en composer.json.

function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

function redirigir(string $destino): never
{
    header("Location: {$destino}");
    exit;
}
