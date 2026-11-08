<?php
// Esta cabecera espera que la página haya definido $titulo y $pagina
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> · Mi web</title>
    <style>
        body { font-family: sans-serif; margin: 0; }
        header { background: #4f7cff; padding: 1rem; }
        nav a { color: white; margin-right: 1rem; text-decoration: none; }
        nav a.activo { font-weight: bold; text-decoration: underline; }
        main { padding: 1rem; min-height: 60vh; }
        footer { background: #eee; padding: 1rem; text-align: center; }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="index.php" class="<?= claseActiva("inicio", $pagina) ?>">Inicio</a>
        <a href="productos.php" class="<?= claseActiva("productos", $pagina) ?>">Productos</a>
        <a href="contacto.php" class="<?= claseActiva("contacto", $pagina) ?>">Contacto</a>
    </nav>
</header>
<main>
