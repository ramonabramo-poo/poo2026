<?php
declare(strict_types=1);

namespace App\Nucleo;

class Sesion
{
    public static function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Los datos "flash" de la petición anterior pasan a estar disponibles en ESTA petición...
        $_SESSION["_flash"] = $_SESSION["_flash_siguiente"] ?? [];
        // ...y se vacía el cajón para la siguiente
        $_SESSION["_flash_siguiente"] = [];
    }

    public static function obtener(string $clave, mixed $porDefecto = null): mixed
    {
        return $_SESSION[$clave] ?? $porDefecto;
    }

    public static function guardar(string $clave, mixed $valor): void
    {
        $_SESSION[$clave] = $valor;
    }

    public static function olvidar(string $clave): void
    {
        unset($_SESSION[$clave]);
    }

    // FLASH: se guarda ahora y solo se puede leer en la PRÓXIMA petición
    public static function flash(string $clave, mixed $valor): void
    {
        $_SESSION["_flash_siguiente"][$clave] = $valor;
    }

    public static function leerFlash(string $clave, mixed $porDefecto = null): mixed
    {
        return $_SESSION["_flash"][$clave] ?? $porDefecto;
    }

    public static function guardarMensaje(string $texto, string $tipo = "ok"): void
    {
        self::flash("mensaje", ["texto" => $texto, "tipo" => $tipo]);
    }

    public static function leerMensaje(): ?array
    {
        return self::leerFlash("mensaje");
    }

    public static function tokenCsrf(): string
    {
        if (empty($_SESSION["csrf"])) {
            $_SESSION["csrf"] = bin2hex(random_bytes(32));
        }
        return $_SESSION["csrf"];
    }

    public static function csrfValido(string $tokenRecibido): bool
    {
        return hash_equals(self::tokenCsrf(), $tokenRecibido);
    }

    public static function regenerar(): void
    {
        session_regenerate_id(true);
    }
}
