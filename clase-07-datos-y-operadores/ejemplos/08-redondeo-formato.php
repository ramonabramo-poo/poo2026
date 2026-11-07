<?php
$precio = 59.90;
$iva = 0.21;
$total = $precio * (1 + $iva);

echo $total;                                // 72.479
echo "<br>";

// round(): redondea a los decimales que digamos
echo round($total, 2);                      // 72.48
echo "<br>";

// floor() hacia abajo, ceil() hacia arriba
echo floor(7.9), " y ", ceil(7.1);          // 7 y 8
echo "<br>";

// number_format(): muestra el número al estilo español
// (número, decimales, separador decimal, separador de miles)
echo number_format($total, 2, ",", ".") . " €";   // 72,48 €
echo "<br>";
echo number_format(1234567.891, 2, ",", ".");      // 1.234.567,89
echo "<br>";

// División entera y resto
echo intdiv(17, 5);   // 3  → cuántas veces cabe el 5 en el 17
echo "<br>";
echo 17 % 5;          // 2  → lo que sobra
