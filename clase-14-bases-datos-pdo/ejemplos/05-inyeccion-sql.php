<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/conexion.php";
require_once __DIR__ . "/includes/funciones.php";

// Lo que escribe un atacante en el campo «email» de un buscador
$emailAtacante = "nadie@ejemplo.com' OR '1'='1";

$pdo = conectar();

// ❌ MAL: pegar el dato del usuario dentro del SQL
$sqlPeligroso = "SELECT nombre, email FROM alumnos WHERE email = '{$emailAtacante}'";
$filasPeligrosas = $pdo->query($sqlPeligroso)->fetchAll();

// ✅ BIEN: consulta preparada con un marcador
$consulta = $pdo->prepare("SELECT nombre, email FROM alumnos WHERE email = :email");
$consulta->execute(["email" => $emailAtacante]);
$filasSeguras = $consulta->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inyección SQL</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; max-width: 760px; }
        pre { background: #f4f4f4; padding: .8rem; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>Inyección SQL: así se cuela un atacante</h1>
    <p>El atacante escribe: <code><?= e($emailAtacante) ?></code></p>

    <h2>❌ Pegando el dato en el SQL</h2>
    <pre><?= e($sqlPeligroso) ?></pre>
    <p>Devuelve <strong><?= count($filasPeligrosas) ?> alumnos</strong>: ¡la tabla entera!</p>

    <h2>✅ Con una consulta preparada</h2>
    <p>Devuelve <strong><?= count($filasSeguras) ?> alumnos</strong>: el texto se trata como un email raro, nada más.</p>
</body>
</html>
