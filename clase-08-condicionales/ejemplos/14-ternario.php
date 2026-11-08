<?php
// Ternario: condición ? valor si se cumple : valor si no
$edad = 15;
$stock = 0;
$cantidad = 1;

$tipo = $edad >= 18 ? "adulto" : "menor";
$disponible = $stock > 0 ? "En stock" : "Agotado";
// Muy útil para los plurales
$texto = $cantidad . ($cantidad === 1 ? " unidad" : " unidades");

echo "Con $edad años eres $tipo<br>";
echo "Producto: $disponible<br>";
echo "Has pedido $texto";
