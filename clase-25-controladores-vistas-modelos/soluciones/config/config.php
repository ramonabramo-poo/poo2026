<?php
declare(strict_types=1);

use App\Nucleo\Entorno;

// Los valores que cambian según el ordenador vienen del .env;
// los que son iguales en todas partes, se quedan aquí.
define("NOMBRE_WEB", Entorno::obtener("APP_NOMBRE", "Mi academia"));
define("DEPURACION", Entorno::obtener("APP_DEPURACION") === "true");

// Ejercicio 08: también viene del .env (APP_POR_PAGINA=8), con 5 si no está
define("CURSOS_POR_PAGINA", (int) Entorno::obtener("APP_POR_PAGINA", "5"));

date_default_timezone_set("Europe/Madrid");

// Ejercicio 03: una variable nueva del .env (añadid APP_CORREO=info@academia.test al .env)
define("CORREO_CONTACTO", Entorno::obtener("APP_CORREO", "sin correo de contacto"));
