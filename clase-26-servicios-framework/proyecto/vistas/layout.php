<?php $mensajeFlash = App\Nucleo\Sesion::leerMensaje(); ?>
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
        <?php if (auth()->comprobar()): ?>
            <a href="/cursos/crear">➕ Nuevo curso</a>
            <span class="usuario">👤 <?= e(auth()->usuario()->nombre) ?></span>
            <form method="post" action="/logout" class="en-linea">
                <?= campoCsrf() ?>
                <button class="enlace">Salir</button>
            </form>
        <?php else: ?>
            <a href="/login">Iniciar sesión</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <?php if ($mensajeFlash !== null): ?>
        <p class="mensaje <?= e($mensajeFlash["tipo"]) ?>"><?= e($mensajeFlash["texto"]) ?></p>
    <?php endif; ?>

    <?= $contenido ?>
</main>
<footer>© <?= date("Y") ?> <?= e(NOMBRE_WEB) ?> · Nuestro propio MVC</footer>
</body>
</html>
