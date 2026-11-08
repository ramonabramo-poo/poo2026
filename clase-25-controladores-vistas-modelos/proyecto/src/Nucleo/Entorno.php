<?php
declare(strict_types=1);

namespace App\Nucleo;

// Lee el archivo .env: una variable por línea, NOMBRE=valor
class Entorno
{
    private static array $variables = [];

    public static function cargar(string $archivo): void
    {
        if (!is_file($archivo)) {
            throw new \RuntimeException("Falta el archivo .env. Copiad .env.ejemplo como .env");
        }

        foreach (file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
            $linea = trim($linea);
            if ($linea === "" || str_starts_with($linea, "#")) {
                continue;                                    // comentario o línea vacía
            }
            [$nombre, $valor] = array_map("trim", explode("=", $linea, 2) + [1 => ""]);
            self::$variables[$nombre] = trim($valor, "\"'");   // quitamos las comillas
        }
    }

    public static function obtener(string $nombre, string $porDefecto = ""): string
    {
        return self::$variables[$nombre] ?? $porDefecto;
    }
}
