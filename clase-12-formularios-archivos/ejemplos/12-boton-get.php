<?php
declare(strict_types=1);

// Igual con GET. Al enviar, mirad la URL: 12-boton-get.php?nombre=Ana&enviar=
$enviado = isset($_GET["enviar"]);
$nombre = trim($_GET["nombre"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Enviado? Con el name del botón (GET)</title>
</head>
<body>
    <?php if ($enviado): ?>
        <p>✅ Has pulsado «Enviar». Hola, <?= htmlspecialchars($nombre) ?>.</p>
    <?php endif; ?>

    <form method="get">
        <input type="text" name="nombre" placeholder="Nombre">
        <button type="submit" name="enviar">Enviar</button>
    </form>
</body>
</html>
