<?php
declare(strict_types=1);

// Formulario GET: el resultado se puede compartir copiando la dirección
$conversiones = [
    "km-millas" => ["km", "millas", 0.621371],
    "millas-km" => ["millas", "km", 1.609344],
    "kg-libras" => ["kg", "libras", 2.204623],
    "libras-kg" => ["libras", "kg", 0.453592],
];

$cantidad = $_GET["cantidad"] ?? "";
$tipo = $_GET["tipo"] ?? "km-millas";
$texto = "";

if ($cantidad !== "" && is_numeric($cantidad) && isset($conversiones[$tipo])) {
    [$desde, $hasta, $factor] = $conversiones[$tipo];
    $convertido = (float) $cantidad * $factor;
    $texto = number_format((float) $cantidad, 2, ",", ".") . " $desde = " . number_format($convertido, 2, ",", ".") . " $hasta";
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Conversor</title></head>
<body>
    <form method="get">
        <input type="number" step="any" name="cantidad" value="<?= htmlspecialchars($cantidad) ?>">
        <select name="tipo">
            <?php foreach ($conversiones as $clave => [$desde, $hasta]): ?>
                <option value="<?= $clave ?>" <?= $clave === $tipo ? "selected" : "" ?>><?= $desde ?> → <?= $hasta ?></option>
            <?php endforeach; ?>
        </select>
        <button>Convertir</button>
    </form>
    <p><?= $texto ?></p>
</body>
</html>
