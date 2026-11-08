<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? "Mi web") ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($titulo ?? "Mi web") ?></h1>
    <ul>
        <?php foreach ($productos ?? [] as $producto): ?>
            <li><?= htmlspecialchars($producto) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
