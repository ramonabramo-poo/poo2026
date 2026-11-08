<?php
declare(strict_types=1);

class Producto
{
    public string $nombre = "";
    public float $precio = 0;

    // Un método es una función que vive dentro de la clase.
    // $this significa «este objeto»: el que ha recibido la orden.
    public function precioConIva(): float
    {
        return round($this->precio * 1.21, 2);
    }

    public function describir(): string
    {
        return "{$this->nombre} ({$this->precioConIva()} € con IVA)";
    }
}

$camiseta = new Producto();
$camiseta->nombre = "Camiseta";
$camiseta->precio = 15;

$gorra = new Producto();
$gorra->nombre = "Gorra";
$gorra->precio = 9.5;

// El mismo método, pero cada objeto usa SUS datos
echo $camiseta->describir() . "<br>";   // Camiseta (18.15 € con IVA)
echo $gorra->describir() . "<br>";      // Gorra (11.5 € con IVA)
