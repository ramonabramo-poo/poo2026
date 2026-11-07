<?php
declare(strict_types=1);

// El trait necesita que la clase tenga un precio: lo exige con un método abstracto
trait ConDescuento
{
    private float $descuento = 0;

    abstract public function precioBase(): float;

    public function aplicarDescuento(float $porcentaje): void
    {
        if ($porcentaje < 0 || $porcentaje > 100) {
            throw new InvalidArgumentException("El descuento debe estar entre 0 y 100.");
        }
        $this->descuento = $porcentaje;
    }

    public function precioFinal(): float
    {
        return round($this->precioBase() * (1 - $this->descuento / 100), 2);
    }
}

class Producto
{
    use ConDescuento;

    public function __construct(public string $nombre, private float $precio)
    {
    }

    public function precioBase(): float
    {
        return $this->precio;
    }
}

class Curso
{
    use ConDescuento;

    public function __construct(public string $titulo, private int $horas, private float $precioHora)
    {
    }

    public function precioBase(): float
    {
        return $this->horas * $this->precioHora;
    }
}

$camiseta = new Producto("Camiseta", 20);
$camiseta->aplicarDescuento(25);

$php = new Curso("PHP 8 desde cero", 80, 3.5);
$php->aplicarDescuento(10);

echo "{$camiseta->nombre}: {$camiseta->precioBase()} € → {$camiseta->precioFinal()} €<br>";   // 20 → 15
echo "{$php->titulo}: {$php->precioBase()} € → {$php->precioFinal()} €<br>";                  // 280 → 252
