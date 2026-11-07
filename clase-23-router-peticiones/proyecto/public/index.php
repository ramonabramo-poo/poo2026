<?php
declare(strict_types=1);

// FRONT CONTROLLER: ahora cabe en unas pocas líneas

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/config.php";

use App\Nucleo\ManejadorErrores;
use App\Nucleo\Peticion;
use App\Nucleo\Router;

ManejadorErrores::registrar(DEPURACION);

$router = new Router();
require __DIR__ . "/../config/rutas.php";

$peticion = Peticion::desdeGlobales();

$respuesta = $router->despachar($peticion);

$respuesta->enviar();
