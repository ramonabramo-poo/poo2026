<?php

namespace App\Servicios;

// Un servicio: una clase que hace UNA tarea y que no es ni controlador ni modelo
class CalculadoraPrecios
{
    public function __construct(
        private float $iva,
        private int $descuentoMaximo,
    ) {}

    public function conIva(float $precio): float
    {
        return round($precio * (1 + $this->iva), 2);
    }

    public function conDescuento(float $precio, int $porcentaje): float
    {
        // Nunca más descuento del permitido por la academia
        $porcentaje = min($porcentaje, $this->descuentoMaximo);

        return round($precio * (100 - $porcentaje) / 100, 2);
    }

    public function formatear(float $importe): string
    {
        return number_format($importe, 2, ',', '.') . ' €';
    }
}
