<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

requerirLogin();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método no permitido.");
}

comprobarCsrf($_POST["csrf"] ?? "");
$pdo = conectar();
$original = obtenerCurso($pdo, (int) ($_POST["id"] ?? 0));

if ($original === null) {
    guardarMensaje("Ese curso no existe.", "error");
    redirigir("index.php");
}

// Reutilizamos las funciones de includes/cursos.php
$copia = [
    "titulo" => mb_substr("Copia de " . $original["titulo"], 0, 120),
    "horas" => (int) $original["horas"],
    "precio" => (float) $original["precio"],
    "plazas" => 20,
];
$idNuevo = crearCurso($pdo, $copia);

guardarMensaje("Curso duplicado: revisa los datos de la copia.");
redirigir("editar.php?id=" . $idNuevo);
