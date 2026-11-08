<?php
declare(strict_types=1);

class Punto
{
    public function __construct(
        public readonly float $x,
        public readonly float $y,
    ) {
    }

    public function distanciaA(Punto $otro): float
    {
        return round(sqrt(($otro->x - $this->x) ** 2 + ($otro->y - $this->y) ** 2), 2);
    }

    // readonly: no podemos mover el punto, así que devolvemos uno NUEVO
    public function desplazar(float $dx, float $dy): Punto
    {
        return new Punto($this->x + $dx, $this->y + $dy);
    }

    public function describir(): string
    {
        return "({$this->x}, {$this->y})";
    }
}

$origen = new Punto(0, 0);
$casa = new Punto(3, 4);
$tienda = $casa->desplazar(2, -1);

echo "De {$origen->describir()} a {$casa->describir()}: " . $origen->distanciaA($casa) . "<br>";
echo "La tienda está en {$tienda->describir()}; la casa sigue en {$casa->describir()}<br>";

try {
    $casa->x = 10;
} catch (Error $error) {
    echo "No se puede cambiar: " . $error->getMessage();
}
