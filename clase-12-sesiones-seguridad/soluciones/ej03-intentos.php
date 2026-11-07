<?php
declare(strict_types=1);

const MAX_INTENTOS = 3;
const BLOQUEO_SEGUNDOS = 60;

// Usuario de prueba: luis / secreto123 (en la vida real, el hash vendría de la base de datos)
$hashGuardado = password_hash("secreto123", PASSWORD_DEFAULT);
$mensaje = "";

session_start();
$_SESSION["intentos"] ??= 0;
$_SESSION["bloqueadoHasta"] ??= 0;
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$usuario = $_POST["usuario"] ?? "";
$clave = $_POST["clave"] ?? "";

$bloqueado = time() < $_SESSION["bloqueadoHasta"];

if ($esEnvio && !$bloqueado) {
    if ($usuario === "luis" && password_verify($clave, $hashGuardado)) {
        $_SESSION["intentos"] = 0;
        $mensaje = "¡Bienvenido, Luis!";
    } else {
        $_SESSION["intentos"]++;
        $restantes = MAX_INTENTOS - $_SESSION["intentos"];
        if ($restantes <= 0) {
            $_SESSION["bloqueadoHasta"] = time() + BLOQUEO_SEGUNDOS;
            $_SESSION["intentos"] = 0;
            $bloqueado = true;
        } else {
            $mensaje = "Datos incorrectos. Intentos restantes: {$restantes}.";
        }
    }
}

if ($bloqueado) {
    $espera = $_SESSION["bloqueadoHasta"] - time();
    $mensaje = "Demasiados intentos. Espera {$espera} segundos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Login con intentos</title></head>
<body>
<h1>Acceso</h1>
<?php if ($mensaje !== ""): ?><p><strong><?= htmlspecialchars($mensaje) ?></strong></p><?php endif; ?>
<?php if (!$bloqueado): ?>
    <form method="post">
        <input name="usuario" placeholder="Usuario">
        <input type="password" name="clave" placeholder="Contraseña">
        <button>Entrar</button>
    </form>
<?php endif; ?>
</body>
</html>
