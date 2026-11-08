<?php
declare(strict_types=1);

session_start();

// Simulamos el usuario guardado; su contraseña inicial es "secreto123"
$_SESSION["hash"] ??= password_hash("secreto123", PASSWORD_DEFAULT);
$errores = [];
$cambiada = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $actual = $_POST["actual"] ?? "";
    $nueva = $_POST["nueva"] ?? "";
    $repetida = $_POST["repetida"] ?? "";

    if (!password_verify($actual, $_SESSION["hash"])) {
        $errores[] = "La contraseña actual no es correcta";
    }
    if (strlen($nueva) < 8) {
        $errores[] = "La nueva debe tener al menos 8 caracteres";
    }
    if ($nueva !== $repetida) {
        $errores[] = "Las dos contraseñas nuevas no coinciden";
    }
    if ($nueva === $actual) {
        $errores[] = "La nueva no puede ser igual que la actual";
    }

    if (count($errores) === 0) {
        $_SESSION["hash"] = password_hash($nueva, PASSWORD_DEFAULT);
        $cambiada = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Cambiar contraseña</title></head>
<body>
    <h1>Cambiar la contraseña</h1>
    <?php if ($cambiada): ?>
        <p style="color: green">Contraseña cambiada.</p>
    <?php endif; ?>
    <?php foreach ($errores as $error): ?>
        <p style="color: red"><?= $error ?></p>
    <?php endforeach; ?>
    <form method="post">
        <p><input type="password" name="actual" placeholder="Contraseña actual"></p>
        <p><input type="password" name="nueva" placeholder="Nueva"></p>
        <p><input type="password" name="repetida" placeholder="Repite la nueva"></p>
        <button>Cambiar</button>
    </form>
</body>
</html>
