<?php
declare(strict_types=1);

namespace Tienda\Facturas;

// …y otra "Linea", de factura, con el MISMO nombre de clase pero en otro namespace
class Linea
{
    public function __construct(
        public readonly string $concepto,
        public readonly float $base,
        public readonly float $iva = 0.21,
    ) {
    }

    public function total(): float
    {
        return round($this->base * (1 + $this->iva), 2);
    }
}
