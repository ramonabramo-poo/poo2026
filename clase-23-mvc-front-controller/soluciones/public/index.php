<?php
declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/config.php";

use App\Controladores\CursosControlador;
use App\Controladores\PaginasControlador;

$metodo = $_SERVER["REQUEST_METHOD"];
$ruta = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$ruta = rtrim($ruta, "/") ?: "/";

// ¡Ojo al orden! /cursos/completos tiene que ir ANTES que /cursos/{id}
if ($metodo === "GET" && ($ruta === "/" || $ruta === "/cursos")) {
    $html = (new CursosControlador())->index();
} elseif ($metodo === "GET" && $ruta === "/cursos/completos") {
    $html = (new CursosControlador())->completos();
} elseif ($metodo === "GET" && $ruta === "/cursos/baratos") {
    $html = (new CursosControlador())->baratos();
} elseif ($metodo === "GET" && $ruta === "/cursos/aleatorio") {
    (new CursosControlador())->aleatorio();
} elseif ($metodo === "GET" && preg_match("#^/cursos/(\d+)/json$#", $ruta, $partes)) {
    $html = (new CursosControlador())->json((int) $partes[1]);
} elseif ($metodo === "GET" && preg_match("#^/cursos/(\d+)$#", $ruta, $partes)) {
    $html = (new CursosControlador())->ver((int) $partes[1]);
} elseif ($metodo === "GET" && $ruta === "/acerca") {
    $html = (new PaginasControlador())->acerca();
} elseif ($metodo === "GET" && $ruta === "/contacto") {
    $html = (new PaginasControlador())->contacto();
} else {
    http_response_code(404);
    // Ejercicio 07: le pasamos a la vista la dirección que se pidió
    $html = vista("errores/404", ["titulo" => "Página no encontrada", "rutaPedida" => $ruta]);
}

echo $html;
