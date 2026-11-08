<?php
// Probad: ej10-pedido-url.php?producto=Café&cantidad=3&precio=4.75
$producto = $_GET["producto"] ?? "Producto sin nombre";
$cantidad = (int) ($_GET["cantidad"] ?? 1);
$precio = (float) ($_GET["precio"] ?? 0);

$total = round($cantidad * $precio, 2);

echo "$cantidad × $producto a " . number_format($precio, 2, ",", ".") . " €";
echo " = " . number_format($total, 2, ",", ".") . " €";
