<?php
declare(strict_types=1);

// GET no necesita un formulario: un enlace con ?clave=valor envía datos igual
$ciudad = $_GET["ciudad"] ?? "";

// Para construir una URL con datos del usuario, http_build_query() codifica los
// caracteres especiales (espacios, ñ, &...) por nosotros
$enlaceSantander = "03-enlaces-get.php?" . http_build_query(["ciudad" => "Santander"]);
$enlaceCoruna = "03-enlaces-get.php?" . http_build_query(["ciudad" => "A Coruña"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos en los enlaces</title>
</head>
<body>
    <h1>El tiempo en…</h1>

    <ul>
        <li><a href="03-enlaces-get.php?ciudad=Madrid">Madrid</a></li>
        <li><a href="<?= $enlaceSantander ?>">Santander</a></li>
        <li><a href="<?= $enlaceCoruna ?>">A Coruña</a> (mirad cómo queda la URL)</li>
    </ul>

    <?php if ($ciudad !== ""): ?>
        <p>Has elegido <strong><?= htmlspecialchars($ciudad) ?></strong>. Hoy, soleado ☀️</p>
    <?php else: ?>
        <p>Elige una ciudad.</p>
    <?php endif; ?>
</body>
</html>
