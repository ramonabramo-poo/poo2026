<?php
declare(strict_types=1);

$carrito = [
    ["producto" => "Teclado", "precio" => 49.90, "cantidad" => 1],
    ["producto" => "Alfombrilla", "precio" => 9.95, "cantidad" => 2],
    ["producto" => "Monitor", "precio" => 189.00, "cantidad" => 1],
];

$total = 0;
foreach ($carrito as $linea) {
    $total += $linea["precio"] * $linea["cantidad"];
}

// Ordenamos de más caro a más barato con usort y la nave espacial
usort($carrito, fn (array $a, array $b): int => $b["precio"] <=> $a["precio"]);

echo "<ol>";
foreach ($carrito as $linea) {
    echo "<li>{$linea["cantidad"]} × {$linea["producto"]} (" . number_format($linea["precio"], 2, ",", ".") . " €)</li>";
}
echo "</ol>";
echo "Productos distintos: " . count($carrito) . "<br>";
echo "El más caro: {$carrito[0]["producto"]}<br>";
echo "Total: " . number_format($total, 2, ",", ".") . " €";
