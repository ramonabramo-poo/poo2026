<?php
declare(strict_types=1);

const IVA = 0.21;

/**
 * @param array<int, array{0: string, 1: float, 2: int}> $lineas producto, precio y unidades
 */
function totalFactura(array $lineas, float $porcentajeDescuento): float
{
    $base = 0.0;
    foreach ($lineas as [$producto, $precioUnidad, $unidades]) {
        $base += $precioUnidad * $unidades;
    }

    $baseConDescuento = $base * (1 - $porcentajeDescuento / 100);

    return round($baseConDescuento * (1 + IVA), 2);
}

$lineas = [["Teclado", 49.90, 1], ["Ratón", 19.90, 2]];
echo totalFactura($lineas, porcentajeDescuento: 10);
