<?php
declare(strict_types=1);

namespace Tienda\Catalogo;

// Ejercicio 05. Tienda\Catalogo\Producto → src/Catalogo/Producto.php (PSR-4)
class Producto
{
    public function __construct(
        public readonly string $nombre,
        public readonly float $precio,
        public readonly Categoria $categoria,
        private int $stock = 0,
    ) {
    }

    public function stock(): int
    {
        return $this->stock;
    }
}
