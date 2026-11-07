<?php
declare(strict_types=1);

namespace App\Nucleo;

// El CONTROLADOR BASE: atajos que heredan todos los controladores
abstract class Controlador
{
    protected function vista(string $nombre, array $datos = [], int $codigo = 200): Respuesta
    {
        return Respuesta::html(Vista::mostrar($nombre, $datos), $codigo);
    }

    protected function redirigir(string $destino, ?string $mensaje = null, string $tipo = "ok"): Respuesta
    {
        if ($mensaje !== null) {
            Sesion::guardarMensaje($mensaje, $tipo);
        }
        return Respuesta::redirigir($destino);
    }

    // Corta la ejecución con un 404: lo recoge el manejador de errores
    protected function noEncontrado(string $mensaje = "No encontramos lo que buscas."): never
    {
        throw new HttpException(404, $mensaje);
    }
}
