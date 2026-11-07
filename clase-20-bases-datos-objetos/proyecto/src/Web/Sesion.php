<?php
declare(strict_types=1);

namespace App\Web;

use App\Modelos\Usuario;

// Todo lo que guardamos en $_SESSION pasa por aquí: mensajes, token CSRF y usuario
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

    public static function comprobarCsrf(string $tokenRecibido): void
    {
        if (!hash_equals(self::tokenCsrf(), $tokenRecibido)) {
            http_response_code(403);
            exit("Petición no autorizada.");
        }
    }

    public static function entrar(Usuario $usuario): void
    {
        session_regenerate_id(true);
        $_SESSION["usuario"] = ["id" => $usuario->id, "nombre" => $usuario->nombre];
    }

    public static function salir(): void
    {
        $_SESSION = [];
        session_destroy();
        session_start();
    }

    public static function usuario(): ?array
    {
        return $_SESSION["usuario"] ?? null;
    }

    public static function requerirLogin(): void
    {
        if (self::usuario() === null) {
            self::guardarMensaje("Inicia sesión para gestionar los cursos.", "error");
            redirigir("login.php");
        }
    }
}
