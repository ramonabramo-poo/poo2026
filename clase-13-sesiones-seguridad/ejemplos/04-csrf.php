<?php
declare(strict_types=1);

$mensaje = "";

session_start();
$esEnvio = $_SERVER["REQUEST_METHOD"] === "POST";
$tokenRecibido = $_POST["csrf"] ?? "";
$email = $_POST["email"] ?? "";

// 1. Generamos un token secreto (una vez por sesión) y lo guardamos en la sesión
if (empty($_SESSION["csrf"])) {
    $_SESSION["csrf"] = bin2hex(random_bytes(32));
}

// 3. Al recibir el formulario, comprobamos que el token coincide
if ($esEnvio) {
    if (!hash_equals($_SESSION["csrf"], $tokenRecibido)) {
        http_response_code(403);
        exit("Petición no autorizada.");
    }
    $mensaje = "Email cambiado a " . htmlspecialchars($email);
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>CSRF</title></head>
<body>
    <h1>Cambiar mi email</h1>
    <?php if ($mensaje !== ""): ?><p style="color: green"><?= $mensaje ?></p><?php endif; ?>

    <form method="post">
        <!-- 2. El token viaja escondido dentro del formulario -->
        <input type="hidden" name="csrf" value="<?= $_SESSION["csrf"] ?>">
        <input name="email" placeholder="Nuevo email">
        <button type="submit">Cambiar</button>
    </form>

    <p>Abrid las herramientas del navegador (F12), cambiad el valor del campo oculto y enviad: veréis el error 403.</p>
</body>
</html>
