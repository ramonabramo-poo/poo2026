<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> · <?= e(NOMBRE_WEB) ?></title>
    <link rel="stylesheet" href="/estilos.css">
</head>
<body>
<header>
    <a class="logo" href="/">🎓 <?= e(NOMBRE_WEB) ?></a>
    <nav>
        <a href="/cursos">Cursos</a>
    </nav>
</header>
<main>
    <?= $contenido ?>
</main>
<footer>© <?= date("Y") ?> <?= e(NOMBRE_WEB) ?> · Nuestro propio MVC</footer>
</body>
</html>
