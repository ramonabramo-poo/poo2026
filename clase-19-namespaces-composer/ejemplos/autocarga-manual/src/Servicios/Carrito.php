<?php
declare(strict_types=1);

namespace App\Servicios;

// Carrito está en otro namespace: para usar Producto, lo importamos con use
use App\Modelos\Producto;

class Carrito
{
    private array $productos = [];

    public function anadir(Producto $producto): void
    {
        $this->productos[] = $producto;
    }

    public function total(): float
    {
        $total = 0;
        foreach ($this->productos as $producto) {
            $total += $producto->precioConIva();
        }
        return round($total, 2);
    }

    public function cuantos(): int
    {
        return count($this->productos);
    }
}
