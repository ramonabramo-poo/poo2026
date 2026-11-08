<?php
// Arrays asociativos: en lugar de posiciones, CLAVES con nombre
$carrito = [
    "Teclado mecánico" => 89.99,
    "Ratón ergonómico" => 45.50,
    "Monitor 27 pulgadas" => 210.00,
];

$total = 0;

foreach ($carrito as $producto => $precio) {
    echo "$producto: " . number_format($precio, 2, ",", ".") . " €<br>";
    $total += $precio;
}

echo "<strong>Total: " . number_format($total, 2, ",", ".") . " €</strong>";
