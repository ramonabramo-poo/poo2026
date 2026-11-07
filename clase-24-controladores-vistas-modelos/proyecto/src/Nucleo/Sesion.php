<?php
declare(strict_types=1);

namespace App\Nucleo;

// La Sesion de la clase 20, como pieza del framework
class Sesion
{
    public static function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function guardarMensaje(string $texto, string $tipo = "ok"): void
    {
        $_SESSION["mensaje"] = ["texto" => $texto, "tipo" => $tipo];
    }

    public static function leerMensaje(): ?array
    {
        $mensaje = $_SESSION["mensaje"] ?? null;
        unset($_SESSION["mensaje"]);
        return $mensaje;
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
}
