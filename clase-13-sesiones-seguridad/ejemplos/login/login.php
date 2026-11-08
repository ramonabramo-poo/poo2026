<?php
declare(strict_types=1);

$error = "";

session_start();
$usuarios = require __DIR__ . "/usuarios.php";
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$usuario = trim($_POST["usuario"] ?? "");
$clave = $_POST["clave"] ?? "";
$haSalido = isset($_GET["salir"]);

// Si ya ha iniciado sesión, no tiene sentido ver el login
if (isset($_SESSION["usuario"])) {
    header("Location: panel.php");
    exit;
}

if ($esEnvio) {
    $datos = $usuarios[$usuario] ?? null;

    if ($datos !== null && password_verify($clave, $datos["hash"])) {
        session_regenerate_id(true);   // nuevo identificador al entrar (más seguro)
        $_SESSION["usuario"] = $usuario;
        $_SESSION["nombre"] = $datos["nombre"];
        $_SESSION["rol"] = $datos["rol"];

        header("Location: panel.php");
        exit;
    }

    // Mismo mensaje tanto si falla el usuario como la contraseña:
    // así no damos pistas a quien intente adivinar
    $error = "Usuario o contraseña incorrectos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Iniciar sesión</title></head>
<body>
    <h1>Iniciar sesión</h1>

    <?php if ($haSalido): ?>
        <p style="color: green">Has cerrado la sesión.</p>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <p style="color: red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <p><input name="usuario" placeholder="Usuario (ana o luis)" value="<?= htmlspecialchars($usuario) ?>"></p>
        <p><input type="password" name="clave" placeholder="Contraseña (secreto123)"></p>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
