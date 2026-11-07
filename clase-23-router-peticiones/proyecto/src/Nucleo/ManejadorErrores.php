<?php
declare(strict_types=1);

namespace App\Nucleo;

use ErrorException;
use Throwable;

// El manejador global de la clase 21, ahora como pieza del framework
class ManejadorErrores
{
    private static bool $depuracion = false;

    public static function registrar(bool $depuracion): void
    {
        self::$depuracion = $depuracion;
        ini_set("display_errors", "0");
        set_error_handler([self::class, "avisoAExcepcion"]);
        set_exception_handler([self::class, "manejar"]);
    }

    public static function avisoAExcepcion(int $nivel, string $mensaje, string $archivo, int $linea): bool
    {
        throw new ErrorException($mensaje, 0, $nivel, $archivo, $linea);
    }

    public static function manejar(Throwable $e): void
    {
        error_log(sprintf("[%s] %s en %s:%d", get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()));

        $html = vista("errores/500", [
            "titulo" => "Error del servidor",
            "detalle" => self::$depuracion ? $e : null,     // detalles SOLO mientras desarrollamos
        ]);
        Respuesta::html($html, 500)->enviar();
    }
}
