<?php
declare(strict_types=1);

use App\Nucleo\Aplicacion;
use App\Nucleo\Auth;
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

function parcial(string $nombre, array $datos = []): string
{
    return Vista::parcial($nombre, $datos);
}

function campoCsrf(): string
{
    return '<input type="hidden" name="csrf" value="' . Sesion::tokenCsrf() . '">';
}

// Cualquier servicio del contenedor: app(Auth::class)
function app(string $id): mixed
{
    return Aplicacion::contenedor()->obtener($id);
}

function auth(): Auth
{
    return app(Auth::class);
}

// El error de validación de un campo (si lo hay), para mostrarlo bajo el campo
function error(string $campo): string
{
    return Sesion::leerFlash("errores", [])[$campo] ?? "";
}

// Lo que el usuario había escrito antes de que fallara la validación
function viejo(string $campo, mixed $porDefecto = ""): string
{
    return (string) (Sesion::leerFlash("viejo", [])[$campo] ?? $porDefecto);
}
