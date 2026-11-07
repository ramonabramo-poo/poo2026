<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";

if ($esEnvio) {
    comprobarCsrf($_POST["csrf"] ?? "");
    $_SESSION = [];
    session_destroy();
    session_start();   // una sesión nueva y vacía, solo para el mensaje de despedida
    guardarMensaje("Has cerrado la sesión.");
}

redirigir("index.php");
