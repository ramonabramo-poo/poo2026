<?php
declare(strict_types=1);

// Un TRAIT es un trozo de código que se "pega" en varias clases que no son familia
trait TieneFechaCreacion
{
    private ?DateTime $creado = null;

    public function marcarCreado(): void
    {
        $this->creado = new DateTime();
    }

    public function fechaCreacion(): string
    {
        if ($this->creado === null) {
            return "sin fecha";
        }
        return $this->creado->format("d/m/Y H:i");
    }
}

class Producto
{
    use TieneFechaCreacion;

    public function __construct(public string $nombre)
    {
        $this->marcarCreado();
    }
}

class Factura
{
    use TieneFechaCreacion;

    public function __construct(public int $numero)
    {
        $this->marcarCreado();
    }
}

date_default_timezone_set("Europe/Madrid");

$taza = new Producto("Taza");
$factura = new Factura(2026001);

echo "Producto {$taza->nombre}, creado el {$taza->fechaCreacion()}<br>";
echo "Factura {$factura->numero}, creada el {$factura->fechaCreacion()}<br>";
// Producto y Factura no tienen nada que ver... pero comparten ese comportamiento
