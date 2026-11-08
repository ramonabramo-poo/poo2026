<?php
$errores = [];
$nombre = "";
$email = "";
$edad = "";
$enviado = $_SERVER["REQUEST_METHOD"] === "POST";

if ($enviado) {
    $nombre = trim($_POST["nombre"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $edad = trim($_POST["edad"] ?? "");

    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido";
    }
    if ((int) $edad < 16 || (int) $edad > 120) {
        $errores[] = "La edad tiene que ser un número entre 16 y 120";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <?php if ($enviado && count($errores) === 0): ?>
        <h1>¡Bienvenido, <?= htmlspecialchars($nombre) ?>!</h1>
    <?php else: ?>
        <?php foreach ($errores as $error): ?>
            <p style="color: red"><?= $error ?></p>
        <?php endforeach; ?>
        <form method="post">
            <p><input name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($nombre) ?>"></p>
            <p><input name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>"></p>
            <p><input name="edad" placeholder="Edad" value="<?= htmlspecialchars($edad) ?>"></p>
            <button>Registrarme</button>
        </form>
    <?php endif; ?>
</body>
</html>
