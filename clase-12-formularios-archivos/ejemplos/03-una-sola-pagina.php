<?php
declare(strict_types=1);

// La misma inscripción, pero el formulario y la respuesta en UN solo archivo
$errores = [];
$inscrito = false;

// ¿Venimos de pulsar el botón (POST) o solo estamos abriendo la página (GET)?
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($esEnvio) {
    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = "El email no tiene un formato válido.";
    }
    $inscrito = count($errores) === 0;
}
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

        <!-- Sin action: el formulario se envía a esta misma página -->
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
