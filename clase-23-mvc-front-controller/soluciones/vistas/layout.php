<?php
// Ejercicio 05: el layout marca la sección activa del menú.
// $seccion es opcional: si el controlador no la manda, ninguna se marca
$seccion ??= "";
$menu = ["cursos" => ["/cursos", "Cursos"], "acerca" => ["/acerca", "Acerca de"], "contacto" => ["/contacto", "Contacto"]];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? "Inicio") ?> · <?= e(NOMBRE_WEB) ?></title>
    <link rel="stylesheet" href="/estilos.css">
    <style>
        nav a.activo { text-decoration: underline; font-weight: bold; }
    </style>
</head>
<body>
<header>
    <a class="logo" href="/">🎓 <?= e(NOMBRE_WEB) ?></a>
    <nav>
        <?php foreach ($menu as $clave => [$enlace, $texto]): ?>
            <a href="<?= $enlace ?>" class="<?= $clave === $seccion ? "activo" : "" ?>"><?= $texto ?></a>
        <?php endforeach; ?>
    </nav>
</header>
<main>
    <?= $contenido ?>
</main>
<footer>© <?= date("Y") ?> <?= e(NOMBRE_WEB) ?> · Nuestro propio MVC</footer>
</body>
</html>
