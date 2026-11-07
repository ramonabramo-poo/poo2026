<?php
declare(strict_types=1);

namespace App\Nucleo;

// El motor de vistas: la función vista() de la clase 22, convertida en clase
class Vista
{
    private const CARPETA = __DIR__ . "/../../vistas/";

    // Una vista completa, dentro del layout
    public static function mostrar(string $nombre, array $datos = [], string $layout = "layout"): string
    {
        $contenido = self::parcial($nombre, $datos);
        return self::parcial($layout, $datos + ["contenido" => $contenido]);
    }

    // Un trozo de vista SIN layout (un formulario, una tarjeta…)
    public static function parcial(string $nombre, array $datos = []): string
    {
        $archivo = self::CARPETA . $nombre . ".php";
        if (!is_file($archivo)) {
            throw new \RuntimeException("No existe la vista «{$nombre}»");
        }

        extract($datos);
        ob_start();
        require $archivo;
        return ob_get_clean();
    }
}
