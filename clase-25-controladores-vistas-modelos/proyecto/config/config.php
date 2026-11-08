<?php
declare(strict_types=1);

use App\Nucleo\Entorno;

// Los valores que cambian según el ordenador vienen del .env;
// los que son iguales en todas partes, se quedan aquí.
define("NOMBRE_WEB", Entorno::obtener("APP_NOMBRE", "Mi academia"));
define("DEPURACION", Entorno::obtener("APP_DEPURACION") === "true");

const CURSOS_POR_PAGINA = 5;

date_default_timezone_set("Europe/Madrid");
