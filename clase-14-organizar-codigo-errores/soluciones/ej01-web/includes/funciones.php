<?php
declare(strict_types=1);

// Todas las funciones de la web, en un único sitio

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

// Devuelve "activo" si el enlace corresponde a la página actual
function claseActiva(string $pagina, string $paginaActual): string
{
    return $pagina === $paginaActual ? "activo" : "";
}
