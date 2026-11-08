<?php
$precios = [
    "pan" => 1.20,
    "leche" => 0.95,
    "huevos" => 2.40,
    "tomates" => 1.80,
];
$cantidades = [
    "pan" => 2,
    "leche" => 6,
    "huevos" => 0,
    "tomates" => 1,
];

$total = 0;
$lineas = 0;

foreach ($cantidades as $producto => $cantidad) {
    if ($cantidad === 0) {
        continue;   // no lo compramos: a por el siguiente
    }

    $importe = $cantidad * $precios[$producto];
    $total += $importe;
    $lineas++;
    echo "$cantidad × $producto = " . number_format($importe, 2, ",", ".") . " €<br>";
}

echo "<strong>$lineas productos · Total: " . number_format($total, 2, ",", ".") . " €</strong>";
