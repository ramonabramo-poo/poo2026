<?php
declare(strict_types=1);

// Varios botones en el mismo formulario: solo viaja el que se ha pulsado.
// Aquí, además, los botones tienen el mismo name y distinto value
$importe = (float) ($_POST["importe"] ?? 0);
$accion = $_POST["accion"] ?? "";
$resultado = "";

if ($accion === "iva") {
    $resultado = "Con IVA: " . number_format($importe * 1.21, 2, ",", ".") . " €";
} elseif ($accion === "descuento") {
    $resultado = "Con un 10 % de descuento: " . number_format($importe * 0.9, 2, ",", ".") . " €";
} elseif ($accion === "dolares") {
    $resultado = "En dólares: " . number_format($importe * 1.08, 2, ",", ".") . " $";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Varios botones</title>
</head>
<body>
    <h1>Calculadora de precios</h1>

    <form method="post">
        <label for="importe">Importe (€)</label>
        <input type="number" step="0.01" id="importe" name="importe" value="<?= $importe ?>">

        <button type="submit" name="accion" value="iva">Añadir IVA</button>
        <button type="submit" name="accion" value="descuento">Aplicar descuento</button>
        <button type="submit" name="accion" value="dolares">Pasar a dólares</button>
    </form>

    <?php if ($resultado !== ""): ?>
        <p><strong><?= $resultado ?></strong></p>
    <?php endif; ?>
</body>
</html>
