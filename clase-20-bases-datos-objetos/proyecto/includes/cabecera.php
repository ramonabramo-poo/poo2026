<?php
// Espera que la página haya definido $titulo
use App\Web\Sesion;

$usuarioConectado = Sesion::usuario();
$mensaje = Sesion::leerMensaje();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> · <?= e(NOMBRE_WEB) ?></title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header>
    <a class="logo" href="index.php">🎓 <?= e(NOMBRE_WEB) ?></a>
    <nav>
        <a href="index.php">Cursos</a>
        <?php if ($usuarioConectado !== null): ?>
            <a href="crear.php">➕ Nuevo curso</a>
            <span class="usuario">👤 <?= e($usuarioConectado["nombre"]) ?></span>
            <form method="post" action="logout.php" class="en-linea">
                <input type="hidden" name="csrf" value="<?= Sesion::tokenCsrf() ?>">
                <button class="enlace">Salir</button>
            </form>
        <?php else: ?>
            <a href="login.php">Iniciar sesión</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <?php if ($mensaje !== null): ?>
        <p class="mensaje <?= e($mensaje["tipo"]) ?>"><?= e($mensaje["texto"]) ?></p>
    <?php endif; ?>
