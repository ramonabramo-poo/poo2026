<?php
declare(strict_types=1);

// Con GET, REQUEST_METHOD NO sirve: al abrir la página es GET… y al enviar, también.
// Lo que cambia es que, al enviar, $_GET trae los campos del formulario
$enviado = isset($_GET["nombre"]);
$nombre = trim($_GET["nombre"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Enviado? Con GET</title>
</head>
<body>
    <p>Método de esta petición: <strong><?= $_SERVER["REQUEST_METHOD"] ?></strong> (siempre GET)</p>

    <?php if ($enviado): ?>
        <p>✅ Formulario recibido. Hola, <?= htmlspecialchars($nombre) ?>.</p>
    <?php else: ?>
        <p>Todavía no has enviado el formulario.</p>
    <?php endif; ?>

    <form method="get">
        <input type="text" name="nombre" placeholder="Nombre">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
