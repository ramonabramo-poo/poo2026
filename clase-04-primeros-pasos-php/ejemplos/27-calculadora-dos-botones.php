<?php
// Dos botones con distinto name en el mismo formulario:
// solo llega el del botón que se ha pulsado
$numero1 = (float) ($_POST["numero1"] ?? 0);
$numero2 = (float) ($_POST["numero2"] ?? 0);
$resultado = "";

if (isset($_POST["sumar"])) {
    $resultado = "$numero1 + $numero2 = " . ($numero1 + $numero2);
} elseif (isset($_POST["restar"])) {
    $resultado = "$numero1 - $numero2 = " . ($numero1 - $numero2);
} elseif (isset($_POST["multiplicar"])) {
    $resultado = "$numero1 × $numero2 = " . ($numero1 * $numero2);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
</head>
<body>
    <form method="post">
        <input type="number" step="any" name="numero1" value="<?php echo $numero1; ?>">
        <input type="number" step="any" name="numero2" value="<?php echo $numero2; ?>">
        <button type="submit" name="sumar">Sumar</button>
        <button type="submit" name="restar">Restar</button>
        <button type="submit" name="multiplicar">Multiplicar</button>
    </form>

    <?php if ($resultado !== ""): ?>
        <p><strong><?php echo $resultado; ?></strong></p>
    <?php endif; ?>
</body>
</html>
