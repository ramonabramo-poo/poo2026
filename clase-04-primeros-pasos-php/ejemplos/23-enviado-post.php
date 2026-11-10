<?php
// La misma página muestra el formulario y lo procesa.
// La primera vez que entramos, la petición es GET; al pulsar el botón, es POST
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $mensaje = "Formulario recibido. Hola, " . htmlspecialchars($nombre) . ".";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Se ha enviado? (POST)</title>
</head>
<body>
    <?php if ($mensaje !== ""): ?>
        <p><?php echo $mensaje; ?></p>
    <?php else: ?>
        <p>Todavía no has enviado el formulario.</p>
    <?php endif; ?>

    <form method="post">
        Nombre: <input type="text" name="nombre">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
