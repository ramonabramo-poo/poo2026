<?php
declare(strict_types=1);

// ANTES (repetido tres veces, con pequeñas diferencias que acaban en errores):
// echo "Subtotal: " . number_format($subtotal, 2, ",", ".") . " €";
// echo "IVA: " . number_format($iva, 2, ",", ".") . "€";       ← ¡sin espacio!
// echo "Total: " . number_format($total, 2, ".", ",") . " €";  ← ¡separadores al revés!

// DESPUÉS: una sola función, una sola forma de hacerlo
function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

function lineaImporte(string $concepto, float $cantidad): string
{
    return "$concepto: " . euros($cantidad) . "<br>";
}

$subtotal = 1250.5;
$iva = $subtotal * 0.21;
$total = $subtotal + $iva;

echo lineaImporte("Subtotal", $subtotal);
echo lineaImporte("IVA", $iva);
echo lineaImporte("Total", $total);
