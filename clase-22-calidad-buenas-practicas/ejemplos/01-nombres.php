<?php
declare(strict_types=1);

// ❌ ANTES: funciona, pero ¿qué hace? Hay que adivinarlo
function calc(array $d, float $x): float
{
    $t = 0;
    foreach ($d as $i) {
        if ($i["p"] > 0) {
            $t += $i["p"] * $i["c"];
        }
    }
    return $t * (1 + $x);
}

// ✅ DESPUÉS: el mismo código, con nombres que lo explican solos
function calcularTotalConIva(array $lineasDelPedido, float $tipoIva): float
{
    $subtotal = 0;
    foreach ($lineasDelPedido as $linea) {
        if ($linea["precio"] > 0) {
            $subtotal += $linea["precio"] * $linea["cantidad"];
        }
    }
    return $subtotal * (1 + $tipoIva);
}

$d = [["p" => 10, "c" => 2], ["p" => 5, "c" => 1]];
$lineas = [["precio" => 10, "cantidad" => 2], ["precio" => 5, "cantidad" => 1]];

echo calc($d, 0.21) . "<br>";                       // 30.25
echo calcularTotalConIva($lineas, 0.21) . "<br>";   // 30.25
