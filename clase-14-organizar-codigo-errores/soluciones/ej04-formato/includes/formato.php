<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

function fechaEs(string $fecha): string
{
    return (new DateTime($fecha))->format("d/m/Y");
}
