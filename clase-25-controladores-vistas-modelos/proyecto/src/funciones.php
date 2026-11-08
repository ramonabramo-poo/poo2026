<?php
declare(strict_types=1);

use App\Nucleo\Sesion;
use App\Nucleo\Vista;

function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

// Atajo para las vistas: incluir un trozo de vista (un formulario, una tarjeta…)
function parcial(string $nombre, array $datos = []): string
{
    return Vista::parcial($nombre, $datos);
}

// Atajo para los formularios: el campo oculto con el token CSRF
function campoCsrf(): string
{
    return '<input type="hidden" name="csrf" value="' . Sesion::tokenCsrf() . '">';
}
