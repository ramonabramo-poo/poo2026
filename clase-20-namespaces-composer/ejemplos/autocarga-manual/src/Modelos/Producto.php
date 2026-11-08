<?php
declare(strict_types=1);

namespace App\Modelos;

class Producto
{
    public const IVA = 0.21;

    public function __construct(
        public readonly string $nombre,
        private float $precio,
    ) {
    }

    public function precioConIva(): float
    {
        return round($this->precio * (1 + self::IVA), 2);
    }
}
