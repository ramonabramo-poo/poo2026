<?php
$nombre = "Marta";
$rol = "editor";
$avisos = 0;

$textoRol = match ($rol) {
    "admin" => "Administradora",
    "editor" => "Editora",
    default => "Usuaria",
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <style>
        .hay-avisos { color: #c92a2a; }
        .sin-avisos { color: #2b8a3e; }
    </style>
</head>
<body>
    <h1>Hola, <?= $nombre ?> (<?= $textoRol ?>)</h1>
    <p class="<?= $avisos > 0 ? "hay-avisos" : "sin-avisos" ?>">
        <?= $avisos === 0 ? "No tienes avisos" : "Tienes $avisos " . ($avisos === 1 ? "aviso" : "avisos") ?>
    </p>
    <?php if ($rol === "admin" || $rol === "editor"): ?>
        <a href="#">Crear contenido</a>
    <?php endif; ?>
    <?php if ($rol === "admin"): ?>
        <a href="#">Gestionar usuarios</a>
    <?php endif; ?>
</body>
</html>
