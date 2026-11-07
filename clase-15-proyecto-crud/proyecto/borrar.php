<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

requerirLogin();
$pdo = conectar();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$id = (int) ($_POST["id"] ?? 0);

// Esta página solo acepta POST: un enlace GET nunca puede borrar nada
if (!$esEnvio) {
    http_response_code(405);
    exit("Método no permitido.");
}

comprobarCsrf($_POST["csrf"] ?? "");

try {
    if (borrarCurso($pdo, $id)) {
        guardarMensaje("Curso borrado.");
    } else {
        guardarMensaje("Ese curso ya no existe.", "error");
    }
} catch (PDOException $e) {
    // 1451: la clave foránea no deja borrar un curso que tiene alumnos
    if (($e->errorInfo[1] ?? 0) !== 1451) {
        throw $e;
    }
    guardarMensaje("No se puede borrar: el curso tiene alumnos matriculados.", "error");
}

redirigir("index.php");
