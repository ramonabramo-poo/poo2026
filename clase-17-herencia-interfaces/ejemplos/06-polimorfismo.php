<?php
declare(strict_types=1);

interface Figura
{
    public function area(): float;
    public function nombre(): string;
}

class Circulo implements Figura
{
    public function __construct(private float $radio)
    {
    }

    public function area(): float
    {
        return M_PI * $this->radio ** 2;
    }

    public function nombre(): string
    {
        return "Círculo de radio {$this->radio}";
    }
}

class Rectangulo implements Figura
{
    public function __construct(private float $base, private float $altura)
    {
    }

    public function area(): float
    {
        return $this->base * $this->altura;
    }

    public function nombre(): string
    {
        return "Rectángulo de {$this->base} x {$this->altura}";
    }
}

class Triangulo implements Figura
{
    public function __construct(private float $base, private float $altura)
    {
    }

    public function area(): float
    {
        return $this->base * $this->altura / 2;
    }

    public function nombre(): string
    {
        return "Triángulo de base {$this->base} y altura {$this->altura}";
    }
}

function areaTotal(array $figuras): float
{
    $total = 0;
    foreach ($figuras as $figura) {
        $total += $figura->area();   // cada figura sabe calcular SU área
    }
    return $total;
}

$figuras = [new Circulo(2), new Rectangulo(4, 2.5), new Triangulo(6, 3)];

// POLIMORFISMO: la misma orden, area(), y cada objeto responde a su manera
foreach ($figuras as $figura) {
    echo $figura->nombre() . ": " . round($figura->area(), 2) . " m²<br>";
}
echo "<strong>Área total: " . round(areaTotal($figuras), 2) . " m²</strong>";
