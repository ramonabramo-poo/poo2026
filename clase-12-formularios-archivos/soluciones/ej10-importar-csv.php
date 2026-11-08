<?php
declare(strict_types=1);

$archivo = __DIR__ . "/datos/productos.csv";
$filas = [];
$total = 0;

$f = fopen($archivo, "r");
$cabecera = fgetcsv($f, null, ";", '"', "\\");   // la primera línea son los títulos
while (($fila = fgetcsv($f, null, ";", '"', "\\")) !== false) {
    [$producto, $cantidad, $precio] = $fila;
    $precio = (float) str_replace(",", ".", $precio);   // "2,50" → 2.5
    $importe = (int) $cantidad * $precio;
    $total += $importe;
    $filas[] = [$producto, (int) $cantidad, $precio, $importe];
}
fclose($f);
?>
<table border="1" cellpadding="6">
    <tr>
        <?php foreach ($cabecera as $titulo): ?>
            <th><?= htmlspecialchars(ucfirst($titulo)) ?></th>
        <?php endforeach; ?>
        <th>Importe</th>
    </tr>
    <?php foreach ($filas as [$producto, $cantidad, $precio, $importe]): ?>
        <tr>
            <td><?= htmlspecialchars($producto) ?></td>
            <td><?= $cantidad ?></td>
            <td><?= number_format($precio, 2, ",", ".") ?> €</td>
            <td><?= number_format($importe, 2, ",", ".") ?> €</td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="3">Total</th>
        <th><?= number_format($total, 2, ",", ".") ?> €</th>
    </tr>
</table>
