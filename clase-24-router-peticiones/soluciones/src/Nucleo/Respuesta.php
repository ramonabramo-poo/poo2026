<?php
declare(strict_types=1);

namespace App\Nucleo;

// Todo lo que devolvemos al navegador: contenido, código de estado y cabeceras
class Respuesta
{
    public function __construct(
        private string $contenido = "",
        private int $codigo = 200,
        private array $cabeceras = ["Content-Type" => "text/html; charset=utf-8"],
    ) {
    }

    public static function html(string $contenido, int $codigo = 200): Respuesta
    {
        return new Respuesta($contenido, $codigo);
    }

    public static function texto(string $contenido, int $codigo = 200): Respuesta
    {
        return new Respuesta($contenido, $codigo, ["Content-Type" => "text/plain; charset=utf-8"]);
    }

    public static function redirigir(string $destino, int $codigo = 302): Respuesta
    {
        return new Respuesta("", $codigo, ["Location" => $destino]);
    }

    // Ejercicio 04: una respuesta en JSON
    public static function json(array $datos, int $codigo = 200): Respuesta
    {
        $json = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        return new Respuesta($json, $codigo, ["Content-Type" => "application/json; charset=utf-8"]);
    }

    // Ejercicio 08: un archivo para descargar
    public static function descarga(string $contenido, string $nombreArchivo, string $tipo = "text/csv; charset=utf-8"): Respuesta
    {
        return new Respuesta($contenido, 200, [
            "Content-Type" => $tipo,
            "Content-Disposition" => "attachment; filename=\"{$nombreArchivo}\"",
        ]);
    }

    // Ejercicio 07: añadir una cabecera sin tocar el resto (devuelve la misma respuesta para encadenar)
    public function conCabecera(string $nombre, string $valor): Respuesta
    {
        $this->cabeceras[$nombre] = $valor;
        return $this;
    }

    public function codigo(): int
    {
        return $this->codigo;
    }

    public function contenido(): string
    {
        return $this->contenido;
    }

    // El ÚNICO sitio de toda la aplicación donde se envían cabeceras y se hace echo
    public function enviar(): void
    {
        http_response_code($this->codigo);
        foreach ($this->cabeceras as $nombre => $valor) {
            header("{$nombre}: {$valor}");
        }
        echo $this->contenido;
    }
}
