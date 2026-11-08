<?php
declare(strict_types=1);

$base = 8.50;
$extras = ["queso" => 1.00, "bacon" => 1.50, "huevo" => 0.80, "jalapenos" => 0.60];
$elegidos = [];
$total = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Con name="extras[]" llega un ARRAY con las casillas marcadas
    $marcados = $_POST["extras"] ?? [];
    // Nos quedamos solo con los extras que existen (nunca nos fiamos de lo que llega)
    $elegidos = array_values(array_filter($marcados, fn ($extra): bool => isset($extras[$extra])));

    $total = $base;
    foreach ($elegidos as $extra) {
        $total += $extras[$extra];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Tu hamburguesa</title></head>
<body>
    <h1>🍔 Hamburguesa (<?= number_format($base, 2, ",", ".") ?> €)</h1>
    <form method="post">
        <?php foreach ($extras as $extra => $precio): ?>
            <label>
                <input type="checkbox" name="extras[]" value="<?= $extra ?>" <?= in_array($extra, $elegidos, true) ? "checked" : "" ?>>
                <?= ucfirst($extra) ?> (+<?= number_format($precio, 2, ",", ".") ?> €)
            </label><br>
        <?php endforeach; ?>
        <button>Calcular</button>
    </form>
    <?php if ($total !== null): ?>
        <p>Total: <strong><?= number_format($total, 2, ",", ".") ?> €</strong></p>
    <?php endif; ?>
</body>
</html>
