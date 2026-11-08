<?php
declare(strict_types=1);

// Lo mismo que en el ejemplo 04, en la mitad de líneas (PHP 8):
// las propiedades se declaran y se asignan en los parámetros del constructor
class Producto
{
    public function __construct(
        public string $nombre,
        public float $precio,
        public int $stock = 0,
    ) {
    }

    public function precioConIva(): float
    {
        return round($this->precio * 1.21, 2);
    }
}

$camiseta = new Producto("Camiseta", 15, 20);
$gorra = new Producto("Gorra", 9.5);        // stock: usa el valor por defecto (0)
$taza = new Producto(precio: 7.95, nombre: "Taza");   // con argumentos con nombre

foreach ([$camiseta, $gorra, $taza] as $producto) {
    echo "{$producto->nombre}: {$producto->precioConIva()} € · stock {$producto->stock}<br>";
}
