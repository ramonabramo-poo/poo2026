<?php
// Ternario corto ?: (el "operador Elvis"): si lo de la izquierda es "verdadero", lo usa; si no, lo de la derecha
$apodo = "";
$nombre = "Lucía";
$descuento = 0;

$saludo = $apodo ?: $nombre;                  // "" es falso → usa $nombre
$textoDescuento = $descuento ?: "sin descuento";  // 0 es falso

echo "Hola, $saludo<br>";
echo "Descuento: $textoDescuento";
