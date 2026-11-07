<?php
declare(strict_types=1);

namespace App\Nucleo;

class Peticion
{
    public function __construct(
        public readonly string $metodo,
        public readonly string $ruta,
        private array $consulta = [],
        private array $formulario = [],
        public readonly string $anterior = "/",    // la página desde la que venimos
        private array $cabeceras = [],
    ) {
    }

    public static function desdeGlobales(): Peticion
    {
        $ruta = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH) ?: "/";
        $ruta = rtrim($ruta, "/") ?: "/";
        $anterior = parse_url($_SERVER["HTTP_REFERER"] ?? "/", PHP_URL_PATH) ?: "/";
        $cabeceras = [
            "content-type" => $_SERVER["CONTENT_TYPE"] ?? "",
            "authorization" => $_SERVER["HTTP_AUTHORIZATION"] ?? "",
            "accept" => $_SERVER["HTTP_ACCEPT"] ?? "",
        ];

        // Las APIs envían los datos como JSON en el CUERPO de la petición, no como formulario
        $datos = $_POST;
        if (str_contains($cabeceras["content-type"], "application/json")) {
            $datos = json_decode(file_get_contents("php://input") ?: "[]", true) ?? [];
        }

        // Los formularios HTML solo saben hacer GET y POST. Con un campo oculto _metodo
        // pueden "disfrazar" un POST de PUT o DELETE (Laravel lo hace con @method)
        $metodo = strtoupper($_SERVER["REQUEST_METHOD"] ?? "GET");
        $disfraz = strtoupper((string) ($datos["_metodo"] ?? ""));
        if ($metodo === "POST" && in_array($disfraz, ["PUT", "DELETE"], true)) {
            $metodo = $disfraz;
        }

        return new Peticion($metodo, $ruta, $_GET, $datos, $anterior, $cabeceras);
    }

    public function cabecera(string $nombre): string
    {
        return $this->cabeceras[strtolower($nombre)] ?? "";
    }

    // El token de "Authorization: Bearer abc123" → "abc123"
    public function tokenBearer(): string
    {
        $autorizacion = $this->cabecera("authorization");
        return str_starts_with($autorizacion, "Bearer ") ? substr($autorizacion, 7) : "";
    }

    public function esApi(): bool
    {
        return str_starts_with($this->ruta, "/api/") || $this->ruta === "/api";
    }

    public function consulta(string $clave, string $porDefecto = ""): string
    {
        return trim((string) ($this->consulta[$clave] ?? $porDefecto));
    }

    public function formulario(string $clave, string $porDefecto = ""): string
    {
        return trim((string) ($this->formulario[$clave] ?? $porDefecto));
    }

    public function todoElFormulario(): array
    {
        return $this->formulario;
    }

    // Valida el formulario. Si algo falla, lanza ValidacionException y el framework
    // vuelve a la página anterior con los errores y lo que el usuario había escrito.
    public function validar(array $reglas): array
    {
        $validador = new Validador($this->formulario, $reglas);

        if ($validador->falla()) {
            throw new ValidacionException($validador->errores(), $this->formulario, $this->anterior);
        }
        return $validador->validados();
    }
}
