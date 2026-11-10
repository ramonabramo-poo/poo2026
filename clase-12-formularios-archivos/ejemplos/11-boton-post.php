<?php
declare(strict_types=1);

// Si el botón tiene name, también viaja con el formulario.
// La clave "enviar" solo existe en $_POST cuando se ha pulsado ese botón
$enviado = isset($_POST["enviar"]);
$nombre = trim($_POST["nombre"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Enviado? Con el name del botón (POST)</title>
</head>
<body>
    <?php if ($enviado): ?>
        <p>✅ Has pulsado «Enviar». Hola, <?= htmlspecialchars($nombre) ?>.</p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre">
        <button type="submit" name="enviar">Enviar</button>
    </form>

    <pre><?php print_r($_POST); ?></pre>
</body>
</html>
