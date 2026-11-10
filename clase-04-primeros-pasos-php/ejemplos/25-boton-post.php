<?php
// Si el botón tiene name, también se envía: $_POST["enviar"] solo existe
// cuando se ha pulsado ESE botón. Así sabemos que el formulario se ha enviado
$mensaje = "";

if (isset($_POST["enviar"])) {
    $nombre = trim($_POST["nombre"] ?? "");
    $mensaje = "Has pulsado «Enviar». Hola, " . htmlspecialchars($nombre) . ".";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Botón con name (POST)</title>
</head>
<body>
    <?php if ($mensaje !== ""): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="post">
        Nombre: <input type="text" name="nombre">
        <button type="submit" name="enviar">Enviar</button>
    </form>
</body>
</html>
