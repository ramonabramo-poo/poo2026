<?php
declare(strict_types=1);

namespace Tienda\Pedidos;

use Tienda\Catalogo\Producto;

// Ejercicio 06: una "Linea" de pedido…
class Linea
{
    public function __construct(
        public readonly Producto $producto,
        public readonly int $unidades,
    ) {
    }

    public function importe(): float
    {
        return $this->producto->precio * $this->unidades;
    }
}
