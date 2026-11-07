<?php
declare(strict_types=1);

namespace App\Nucleo;

// Guarda el contenedor para que las funciones de atajo (app(), auth()…) lo encuentren
class Aplicacion
{
    private static ?Contenedor $contenedor = null;

    public static function arrancar(Contenedor $contenedor): void
    {
        self::$contenedor = $contenedor;
    }

    public static function contenedor(): Contenedor
    {
        return self::$contenedor ?? throw new \RuntimeException("La aplicación no ha arrancado.");
    }
}
