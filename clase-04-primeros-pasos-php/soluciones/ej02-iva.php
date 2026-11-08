<?php
const IVA = 0.21;

$precio = 59.90;
$cuotaIva = $precio * IVA;
$precioFinal = $precio + $cuotaIva;

echo "Precio sin IVA: " . number_format($precio, 2, ",", ".") . " €<br>";
echo "IVA (21 %): " . number_format($cuotaIva, 2, ",", ".") . " €<br>";
echo "Precio final: " . number_format($precioFinal, 2, ",", ".") . " €";
