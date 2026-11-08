<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\Web\Sesion;

$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";

if ($esEnvio) {
    Sesion::comprobarCsrf($_POST["csrf"] ?? "");
    Sesion::salir();
    Sesion::guardarMensaje("Has cerrado la sesión.");
}

redirigir("index.php");
