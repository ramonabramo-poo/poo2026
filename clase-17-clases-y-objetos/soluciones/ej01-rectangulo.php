<?php
declare(strict_types=1);

class Rectangulo
{
    public function __construct(
        private float $base,
        private float $altura,
    ) {
        if ($base <= 0 || $altura <= 0) {
            throw new InvalidArgumentException("La base y la altura deben ser positivas.");
        }
    }

    public function area(): float
    {
        return $this->base * $this->altura;
    }

    public function perimetro(): float
    {
        return 2 * ($this->base + $this->altura);
    }

    public function esCuadrado(): bool
    {
        return $this->base === $this->altura;
    }

    public function describir(): string
    {
        $tipo = $this->esCuadrado() ? "cuadrado" : "rectángulo";
        return "{$tipo} de {$this->base} x {$this->altura}: área {$this->area()}, perímetro {$this->perimetro()}";
    }
}

$figuras = [new Rectangulo(4, 2.5), new Rectangulo(3, 3)];

foreach ($figuras as $figura) {
    echo $figura->describir() . "<br>";
}

try {
    new Rectangulo(-1, 5);
} catch (InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}";
}
