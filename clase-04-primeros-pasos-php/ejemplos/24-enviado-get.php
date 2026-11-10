<?php
// Con GET, REQUEST_METHOD NO nos sirve: al entrar por primera vez en la página
// también es una petición GET. Lo que cambia es que, al enviar, $_GET trae el campo
$mensaje = "";

if (isset($_GET["nombre"])) {
    $nombre = trim($_GET["nombre"]);
    $mensaje = "Formulario recibido. Hola, " . htmlspecialchars($nombre) . ".";
}

// Comprobadlo: esto vale "GET" tanto al entrar como al enviar
$metodo = $_SERVER["REQUEST_METHOD"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Se ha enviado? (GET)</title>
</head>
<body>
    <p>Método de esta petición: <strong><?php echo $metodo; ?></strong></p>

    <?php if ($mensaje !== ""): ?>
        <p><?php echo $mensaje; ?></p>
    <?php else: ?>
        <p>Todavía no has enviado el formulario.</p>
    <?php endif; ?>

    <form method="get">
        Nombre: <input type="text" name="nombre">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
