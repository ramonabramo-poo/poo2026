<?php
declare(strict_types=1);

const MINUTOS_INACTIVIDAD = 5;

session_start();
$caducada = false;

$ultima = $_SESSION["ultimaActividad"] ?? time();
if (time() - $ultima > MINUTOS_INACTIVIDAD * 60) {
    // Demasiado tiempo sin hacer nada: cerramos la sesión
    $_SESSION = [];
    session_destroy();
    session_start();
    $caducada = true;
}
$_SESSION["ultimaActividad"] = time();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Inactividad</title></head>
<body>
    <?php if ($caducada): ?>
        <p style="color: red">Tu sesión había caducado por inactividad. Vuelve a entrar.</p>
    <?php else: ?>
        <p>Sesión activa. Si pasas más de <?= MINUTOS_INACTIVIDAD ?> minutos sin recargar, se cerrará.</p>
    <?php endif; ?>
</body>
</html>
