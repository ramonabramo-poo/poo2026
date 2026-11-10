<?php
declare(strict_types=1);

// Una página para "espiar" lo que llega. Muy útil cuando un formulario no funciona
$metodo = $_SERVER["REQUEST_METHOD"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Qué llega?</title>
</head>
<body>
    <h1>¿Qué llega a PHP?</h1>

    <form action="06-ver-datos.php?origen=formulario" method="post">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="ciudad" placeholder="Ciudad">
        <button type="submit">Enviar por POST</button>
    </form>

    <form method="get">
        <input type="text" name="buscar" placeholder="Buscar">
        <button type="submit">Enviar por GET</button>
    </form>

    <p>Método de la petición: <strong><?= $metodo ?></strong></p>

    <h2>$_GET</h2>
    <pre><?php var_dump($_GET); ?></pre>

    <h2>$_POST</h2>
    <pre><?php print_r($_POST); ?></pre>
</body>
</html>
