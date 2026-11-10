<?php
declare(strict_types=1);

// Esta página SOLO recibe: los datos llegan en $_POST con la clave del name de cada campo
$errores = [];

$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($nombre === "") {
    $errores[] = "El nombre es obligatorio.";
}
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $errores[] = "El email no tiene un formato válido.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción</title>
</head>
<body>
    <?php if (count($errores) === 0): ?>
        <h1>¡Inscripción recibida!</h1>
        <p>Gracias, <?= htmlspecialchars($nombre) ?>. Te escribiremos a <?= htmlspecialchars($email) ?>.</p>
    <?php else: ?>
        <h1>Faltan datos</h1>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <!-- El usuario tiene que volver atrás… y puede que lo escrito se haya perdido -->
        <p><a href="14-inscripcion.html">← Volver al formulario</a></p>
    <?php endif; ?>
</body>
</html>
