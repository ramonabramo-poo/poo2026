<?php
declare(strict_types=1);

session_start();

// EL GUARDIÁN: sin sesión, fuera
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;   // ¡imprescindible! Sin él, el resto de la página se ejecutaría igualmente
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Panel privado</title></head>
<body>
    <h1>Hola, <?= htmlspecialchars($_SESSION["nombre"]) ?></h1>
    <p>Tu rol es: <strong><?= htmlspecialchars($_SESSION["rol"]) ?></strong></p>

    <?php if ($_SESSION["rol"] === "admin"): ?>
        <p>🔧 Esta parte solo la ven los administradores.</p>
    <?php endif; ?>

    <form method="post" action="logout.php">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>
