<?php
declare(strict_types=1);

namespace Tienda\Pagos;

// Ejercicio 08
interface MetodoPago
{
    public function cobrar(float $importe): string;
}
