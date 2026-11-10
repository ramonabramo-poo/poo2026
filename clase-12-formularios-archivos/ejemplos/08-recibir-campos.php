<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

// Cada tipo de campo llega de una forma. Y algunos, si no se rellenan, ni siquiera llegan
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$edad = (int) ($_POST["edad"] ?? 0);           // llega como TEXTO: lo convertimos
$fecha = $_POST["fecha"] ?? "";                  // texto con el formato AAAA-MM-DD
$turno = $_POST["turno"] ?? "sin elegir";        // radio sin marcar: no llega
$lenguajes = $_POST["lenguajes"] ?? [];          // casillas con []: un array (o nada)
$ciudad = $_POST["ciudad"] ?? "";                // select: el value de la opción
$comentario = trim($_POST["comentario"] ?? "");
$boletin = isset($_POST["boletin"]);             // casilla suelta: ¿existe o no?
$origen = $_POST["origen"] ?? "";                // campo oculto
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos recibidos</title>
</head>
<body>
    <h1>Esto es lo que ha llegado</h1>

    <table border="1" cellpadding="6">
        <tr><th>Nombre</th><td><?= e($nombre) ?></td></tr>
        <tr><th>Email</th><td><?= e($email) ?></td></tr>
        <tr><th>Edad</th><td><?= $edad ?> (el año que viene, <?= $edad + 1 ?>)</td></tr>
        <tr><th>Fecha de inicio</th><td><?= $fecha !== "" ? date("d/m/Y", strtotime($fecha)) : "sin fecha" ?></td></tr>
        <tr><th>Turno</th><td><?= e($turno) ?></td></tr>
        <tr><th>Lenguajes</th><td><?= count($lenguajes) > 0 ? e(implode(", ", $lenguajes)) : "ninguno" ?></td></tr>
        <tr><th>Ciudad</th><td><?= $ciudad !== "" ? e($ciudad) : "sin elegir" ?></td></tr>
        <tr><th>Comentario</th><td><?= nl2br(e($comentario)) ?></td></tr>
        <tr><th>Boletín</th><td><?= $boletin ? "Sí" : "No" ?></td></tr>
        <tr><th>Origen (oculto)</th><td><?= e($origen) ?></td></tr>
    </table>

    <h2>Y así es $_POST por dentro</h2>
    <pre><?php var_dump($_POST); ?></pre>

    <p><a href="07-tipos-de-campos.html">Volver</a></p>
</body>
</html>
