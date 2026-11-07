<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class Precios
{
    public const IVA_GENERAL = 0.21;

    public static function conIva(float $precio, float $tipo = self::IVA_GENERAL): float
    {
        return round($precio * (1 + $tipo), 2);
    }

    public static function conDescuento(float $precio, float $porcentaje): float
    {
        if ($porcentaje < 0 || $porcentaje > 100) {
            throw new InvalidArgumentException("El descuento debe estar entre 0 y 100.");
        }

        return round($precio * (1 - $porcentaje / 100), 2);
    }

    /**
     * @param array<int, array{precio: float, cantidad: int}> $lineas
     */
    public static function total(array $lineas): float
    {
        $total = 0.0;
        foreach ($lineas as $linea) {
            $total += $linea["precio"] * $linea["cantidad"];
        }

        return round($total, 2);
    }
}
