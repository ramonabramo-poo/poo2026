<?php
declare(strict_types=1);

// Una sola línea en cada página carga TODO: configuración, clases (autocarga) y sesión
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../vendor/autoload.php";

App\Web\Sesion::iniciar();
