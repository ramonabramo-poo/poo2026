<?php
declare(strict_types=1);

// FRONT CONTROLLER: TODAS las peticiones de la web entran por aquí

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/config.php";

use App\Controladores\CursosControlador;

$metodo = $_SERVER["REQUEST_METHOD"];
$ruta = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$ruta = rtrim($ruta, "/") ?: "/";      // "/cursos/" y "/cursos" son la misma ruta

$controlador = new CursosControlador();

// El enrutado más sencillo posible: según el método y la ruta, llamamos a un método del controlador
if ($metodo === "GET" && ($ruta === "/" || $ruta === "/cursos")) {
    $html = $controlador->index();
} elseif ($metodo === "GET" && preg_match("#^/cursos/(\d+)$#", $ruta, $partes)) {
    $html = $controlador->ver((int) $partes[1]);
} else {
    http_response_code(404);
    $html = vista("errores/404", ["titulo" => "Página no encontrada"]);
}

echo $html;
