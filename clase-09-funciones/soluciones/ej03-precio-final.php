<?php
declare(strict_types=1);

function precioFinal(float $precio, float $descuento = 0, float $iva = 0.21): float
{
    $conDescuento = $precio * (1 - $descuento);
    return round($conDescuento * (1 + $iva), 2);
}

function formatoEuros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

echo formatoEuros(precioFinal(100)) . "<br>";                     // 121,00 €
echo formatoEuros(precioFinal(100, 0.20)) . "<br>";               // 96,80 €
echo formatoEuros(precioFinal(100, iva: 0.10)) . "<br>";          // 110,00 €
echo formatoEuros(precioFinal(100, descuento: 0.5, iva: 0.04));   // 52,00 €
