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
        return "Círculo (r = {$this->radio})";
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
        return "Rectángulo ({$this->base} x {$this->altura})";
    }
}

class Cuadrado extends Rectangulo
{
    public function __construct(float $lado)
    {
        parent::__construct($lado, $lado);
    }

    public function nombre(): string
    {
        return "Cuadrado (" . sqrt($this->area()) . " de lado)";
    }
}

$figuras = [new Rectangulo(4, 2.5), new Circulo(1), new Cuadrado(5), new Circulo(3)];
$circulos = 0;

// usort ordena con nuestra regla; <=> devuelve -1, 0 o 1 al comparar dos valores
usort($figuras, fn(Figura $a, Figura $b) => $a->area() <=> $b->area());

foreach ($figuras as $figura) {
    if ($figura instanceof Circulo) {
        $circulos++;
    }
}

foreach ($figuras as $figura) {
    echo $figura->nombre() . ": " . round($figura->area(), 2) . "<br>";
}
echo "Hay {$circulos} círculos. ¿Un Cuadrado es un Rectangulo? ";
var_dump(new Cuadrado(2) instanceof Rectangulo);   // bool(true)
