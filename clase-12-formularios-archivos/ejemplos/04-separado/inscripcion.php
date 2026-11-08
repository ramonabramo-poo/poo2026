<?php
declare(strict_types=1);

// EL CONTROLADOR: recibe la petición, comprueba los datos y decide qué se muestra.
// No escribe ni una etiqueta HTML.

function validarInscripcion(string $nombre, string $email): array
{
    $errores = [];
    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = "El email no tiene un formato válido.";
    }
    return $errores;
}

$errores = [];
$inscrito = false;

$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($esEnvio) {
    $errores = validarInscripcion($nombre, $email);
    $inscrito = count($errores) === 0;
    // Aquí iría guardar la inscripción en un fichero o en la base de datos
}

// LA VISTA: solo pinta con los datos que le hemos preparado
require __DIR__ . "/vistas/inscripcion.vista.php";
