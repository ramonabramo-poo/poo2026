<?php
// Con una función, la receta se escribe UNA vez
function precioConIva($precio)
{
    return number_format($precio * 1.21, 2, ",", ".") . " €";
}

$camiseta = 15;
$pantalon = 32.5;
$zapatillas = 59.9;

// SIN la función: el mismo cálculo copiado tres veces
echo "Camiseta: " . number_format($camiseta * 1.21, 2, ",", ".") . " €<br>";
echo "Pantalón: " . number_format($pantalon * 1.21, 2, ",", ".") . " €<br>";
echo "Zapatillas: " . number_format($zapatillas * 1.21, 2, ",", ".") . " €<br>";

echo "<hr>";

// CON la función: si mañana cambia el IVA, solo hay que tocar UNA línea
echo "Camiseta: " . precioConIva($camiseta) . "<br>";
echo "Pantalón: " . precioConIva($pantalon) . "<br>";
echo "Zapatillas: " . precioConIva($zapatillas) . "<br>";
