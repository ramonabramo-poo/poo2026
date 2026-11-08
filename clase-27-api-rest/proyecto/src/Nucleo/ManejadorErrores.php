<?php
declare(strict_types=1);

namespace App\Nucleo;

use ErrorException;
use Throwable;

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
        // Si el error ocurre en la API, el cliente espera JSON, no una página HTML
        if (str_starts_with(parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH) ?: "/", "/api/")) {
            self::manejarApi($e);
            return;
        }

        // Datos no válidos: volvemos atrás con los errores y lo que había escrito el usuario
        if ($e instanceof ValidacionException) {
            Sesion::flash("errores", $e->errores);
            Sesion::flash("viejo", $e->datos);
            Respuesta::redirigir($e->volverA)->enviar();
            return;
        }

        // Las HttpException (403, 404…) son "errores esperados": tienen su propia página
        if ($e instanceof HttpException) {
            $html = Vista::mostrar("errores/{$e->codigo}", ["titulo" => "Error {$e->codigo}", "mensaje" => $e->getMessage()]);
            Respuesta::html($html, $e->codigo)->enviar();
            return;
        }

        error_log(sprintf("[%s] %s en %s:%d", get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()));
        $html = Vista::mostrar("errores/500", [
            "titulo" => "Error del servidor",
            "detalle" => self::$depuracion ? $e : null,
        ]);
        Respuesta::html($html, 500)->enviar();
    }

    private static function manejarApi(Throwable $e): void
    {
        [$codigo, $cuerpo] = match (true) {
            $e instanceof ValidacionException => [422, ["error" => "Los datos no son válidos.", "errores" => $e->errores]],
            $e instanceof HttpException => [$e->codigo, ["error" => $e->getMessage()]],
            default => [500, ["error" => "Error del servidor."]],
        };

        if ($codigo === 500) {
            error_log(sprintf("[%s] %s en %s:%d", get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()));
            if (self::$depuracion) {
                $cuerpo["detalle"] = get_class($e) . ": " . $e->getMessage();
            }
        }
        Respuesta::json($cuerpo, $codigo)->enviar();
    }
}
