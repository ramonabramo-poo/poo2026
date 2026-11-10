<?php
declare(strict_types=1);

// Una sola página que pregunta y responde. ¿Cómo sabe en qué momento está?
// Al ABRIRLA (escribiendo la dirección o con un enlace) la petición es GET;
// al pulsar el botón de un formulario POST, la petición es POST
$enviado = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Enviado? Con REQUEST_METHOD</title>
</head>
<body>
    <p>Método de esta petición: <strong><?= $_SERVER["REQUEST_METHOD"] ?></strong></p>

    <?php if ($enviado): ?>
        <p>✅ Formulario recibido. Hola, <?= htmlspecialchars($nombre) ?>.</p>
    <?php else: ?>
        <p>Todavía no has enviado el formulario.</p>
    <?php endif; ?>

    <!-- Sin action: se envía a esta misma página -->
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
