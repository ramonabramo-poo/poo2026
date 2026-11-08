<?php
// LA VISTA: solo HTML y "huecos" para los datos. No lee $_POST ni valida nada.
// Recibe del controlador: $inscrito, $errores, $nombre y $email
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción</title>
</head>
<body>
    <h1>Inscripción al taller</h1>

    <?php if ($inscrito): ?>
        <p>Gracias, <?= htmlspecialchars($nombre) ?>. Te escribiremos a <?= htmlspecialchars($email) ?>.</p>
    <?php else: ?>
        <?php foreach ($errores as $error): ?>
            <p style="color: #b00020"><?= $error ?></p>
        <?php endforeach; ?>

        <form method="post">
            <p>
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
            </p>
            <p>
                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            </p>
            <button type="submit">Inscribirme</button>
        </form>
    <?php endif; ?>
</body>
</html>
