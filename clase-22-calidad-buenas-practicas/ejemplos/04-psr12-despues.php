<?php

declare(strict_types=1);

// ✅ El mismo código siguiendo PSR-12 y nuestras normas de estilo
class Producto
{
    public function __construct(
        public string $nombre,
        private float $precio,
    ) {
    }

    public function precioConIva(): float
    {
        if ($this->precio <= 0) {
            return 0;
        }

        return $this->precio * 1.21;
    }
}

$taza = new Producto("Taza", 7.95);

echo $taza->precioConIva();
