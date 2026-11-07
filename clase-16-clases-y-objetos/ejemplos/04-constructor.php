<?php
declare(strict_types=1);

class Producto
{
    public string $nombre;
    public float $precio;

    // El constructor se ejecuta SOLO al hacer new: prepara el objeto
    public function __construct(string $nombre, float $precio)
    {
        $this->nombre = $nombre;
        $this->precio = $precio;
    }

    public function precioConIva(): float
    {
        return round($this->precio * 1.21, 2);
    }
}

// Ahora el objeto nace con sus datos: imposible olvidarse de alguno
$camiseta = new Producto("Camiseta", 15);
$gorra = new Producto("Gorra", 9.5);

echo "{$camiseta->nombre}: {$camiseta->precioConIva()} €<br>";
echo "{$gorra->nombre}: {$gorra->precioConIva()} €<br>";

// Quitad las // y veréis el error: falta un dato obligatorio
// $taza = new Producto("Taza");
