<?php
declare(strict_types=1);

$hash = "";
$comprobacion = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave = $_POST["clave"] ?? "";
    $repetida = $_POST["repetida"] ?? "";

    // Cada vez sale un hash distinto (lleva "sal" aleatoria)... y aun así se puede comprobar
    $hash = password_hash($clave, PASSWORD_DEFAULT);
    $comprobacion = password_verify($repetida, $hash)
        ? "✅ La segunda contraseña coincide con el hash"
        : "❌ La segunda contraseña NO coincide";
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Hash</title></head>
<body>
    <form method="post">
        <p><input type="password" name="clave" placeholder="Contraseña"></p>
        <p><input type="password" name="repetida" placeholder="Escríbela otra vez para comprobar"></p>
        <button>Generar y comprobar</button>
    </form>
    <?php if ($hash !== ""): ?>
        <p><code><?= htmlspecialchars($hash) ?></code></p>
        <p><?= $comprobacion ?></p>
    <?php endif; ?>
</body>
</html>
