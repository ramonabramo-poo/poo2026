<?php
declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use App\Nucleo\Entorno;
use App\Nucleo\ManejadorErrores;
use App\Nucleo\Peticion;
use App\Nucleo\Router;
use App\Nucleo\Sesion;

Entorno::cargar(__DIR__ . "/../.env");
require_once __DIR__ . "/../config/config.php";
ManejadorErrores::registrar(DEPURACION);
Sesion::iniciar();

$router = new Router();
require __DIR__ . "/../config/rutas.php";

$peticion = Peticion::desdeGlobales();

$respuesta = $router->despachar($peticion);

$respuesta->enviar();
