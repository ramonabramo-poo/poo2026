<?php
declare(strict_types=1);

// Escapa cualquier valor (texto, número o null) para mostrarlo en el HTML
function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}
