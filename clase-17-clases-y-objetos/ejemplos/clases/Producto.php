<?php
declare(strict_types=1);

// Una clase por archivo, y el archivo se llama EXACTAMENTE como la clase
class Producto
{
    public const IVA = 0.21;

    public function __construct(
        public readonly string $nombre,
        private float $precio,
        private int $stock = 0,
    ) {
        if ($precio < 0) {
            throw new InvalidArgumentException("El precio no puede ser negativo.");
        }
    }

    // Crea un Producto a partir de una fila de la base de datos (o de cualquier array)
    public static function desdeArray(array $fila): Producto
    {
        return new Producto($fila["nombre"], (float) $fila["precio"], (int) $fila["stock"]);
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function precioConIva(): float
    {
        return round($this->precio * (1 + self::IVA), 2);
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function hayStock(): bool
    {
        return $this->stock > 0;
    }

    public function vender(int $unidades = 1): void
    {
        if ($unidades > $this->stock) {
            throw new RuntimeException("No hay stock suficiente de {$this->nombre}.");
        }
        $this->stock -= $unidades;
    }
}
