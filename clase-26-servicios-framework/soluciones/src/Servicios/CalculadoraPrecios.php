<?php
declare(strict_types=1);

namespace App\Servicios;

// Ejercicio 07: un servicio que el contenedor fabrica con su configuración
class CalculadoraPrecios
{
    public function __construct(private float $iva, private int $descuentoMaximo)
    {
    }

    public function total(float $precio, int $descuento): float
    {
        $descuento = min(max(0, $descuento), $this->descuentoMaximo);
        return round($precio * (100 - $descuento) / 100 * (1 + $this->iva), 2);
    }
}
