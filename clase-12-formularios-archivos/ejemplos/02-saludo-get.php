<?php
declare(strict_types=1);

// Mirad la barra de direcciones: 02-saludo-get.php?nombre=Ana&edad=25
// Cada name del formulario es una clave de $_GET
$nombre = $_GET["nombre"];
$edad = $_GET["edad"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Saludo con GET</title>
</head>
<body>
    <h1>¡Hola, <?php echo $nombre; ?>!</h1>
    <p>Tienes <?php echo $edad; ?> años.</p>
    <p><a href="01-saludo-get.html">Volver</a></p>
</body>
</html>
