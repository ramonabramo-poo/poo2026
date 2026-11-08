<?php
const IVA = 0.21;
const DESCUENTO_SOCIOS = 0.15;

$precio = 120;
$esSocio = true;

$descuento = $esSocio ? $precio * DESCUENTO_SOCIOS : 0;
$base = $precio - $descuento;
$total = $base * (1 + IVA);

echo "Precio: " . number_format($precio, 2, ",", ".") . " €<br>";
echo "Descuento: " . number_format($descuento, 2, ",", ".") . " €<br>";
echo "Total con IVA: " . number_format($total, 2, ",", ".") . " €";
