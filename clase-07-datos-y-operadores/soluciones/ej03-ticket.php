<?php
const IVA = 0.21;

$producto = "Auriculares";
$precio = 24.95;
$unidades = 3;

$base = $precio * $unidades;
$cuotaIva = $base * IVA;
$total = $base + $cuotaIva;

echo "<h2>Ticket</h2>";
echo "$unidades x $producto<br>";
echo "Base: " . number_format($base, 2, ",", ".") . " €<br>";
echo "IVA (21 %): " . number_format($cuotaIva, 2, ",", ".") . " €<br>";
echo "<strong>Total: " . number_format($total, 2, ",", ".") . " €</strong>";
