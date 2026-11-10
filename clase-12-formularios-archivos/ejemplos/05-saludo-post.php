<?php
declare(strict_types=1);

// Ahora la URL es solo 05-saludo-post.php: los datos llegan en $_POST
$usuario = $_POST["usuario"];
$clave = $_POST["clave"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso con POST</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $usuario; ?></h1>
    <!-- Jamás se muestra una contraseña: aquí solo contamos sus caracteres -->
    <p>Tu contraseña tiene <?php echo strlen($clave); ?> caracteres.</p>
    <p><a href="04-saludo-post.html">Volver</a></p>
</body>
</html>
