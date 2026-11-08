<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

requerirLogin();

// Solo POST: un enlace GET nunca puede borrar nada
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método no permitido.");
}

comprobarCsrf($_POST["csrf"] ?? "");

$pdo = conectar();
$borrar = $pdo->prepare("DELETE FROM alumnos WHERE id = :id");
$borrar->execute(["id" => (int) ($_POST["id"] ?? 0)]);

guardarMensaje($borrar->rowCount() === 1 ? "Alumno borrado." : "Ese alumno ya no existe.", $borrar->rowCount() === 1 ? "ok" : "error");
redirigir("alumnos.php");
