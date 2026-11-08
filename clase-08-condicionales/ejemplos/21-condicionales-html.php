<?php
// Condicionales dentro del HTML: sintaxis alternativa y ternario en atributos
$usuarioLogueado = true;
$nombre = "Lucía";
$mensajesSinLeer = 3;
$esAdmin = false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi panel</title>
    <style>
        .aviso { color: #c92a2a; font-weight: bold; }
        .normal { color: #555; }
    </style>
</head>
<body>
    <?php if ($usuarioLogueado): ?>
        <h1>Bienvenida, <?= $nombre ?></h1>
        <p class="<?= $mensajesSinLeer > 0 ? "aviso" : "normal" ?>">
            Tienes <?= $mensajesSinLeer ?> <?= $mensajesSinLeer === 1 ? "mensaje" : "mensajes" ?> sin leer
        </p>
        <?php if ($esAdmin): ?>
            <a href="#">Panel de administración</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="#">Iniciar sesión</a>
    <?php endif; ?>
</body>
</html>
