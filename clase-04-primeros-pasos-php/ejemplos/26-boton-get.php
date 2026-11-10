<?php
// Lo mismo con GET: mirad la URL al enviar → 26-boton-get.php?nombre=Ana&enviar=
$mensaje = "";

if (isset($_GET["enviar"])) {
    $nombre = trim($_GET["nombre"] ?? "");
    $mensaje = "Has pulsado «Enviar». Hola, " . htmlspecialchars($nombre) . ".";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Botón con name (GET)</title>
</head>
<body>
    <?php if ($mensaje !== ""): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="get">
        Nombre: <input type="text" name="nombre">
        <button type="submit" name="enviar">Enviar</button>
    </form>
</body>
</html>
