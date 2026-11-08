<?php
declare(strict_types=1);

abstract class Vehiculo
{
    public function __construct(
        protected string $marca,
        protected string $modelo,
    ) {
    }

    abstract public function ruedas(): int;

    public function describir(): string
    {
        return "{$this->marca} {$this->modelo}, {$this->ruedas()} ruedas";
    }
}

class Coche extends Vehiculo
{
    public function __construct(string $marca, string $modelo, private int $puertas = 5)
    {
        parent::__construct($marca, $modelo);
    }

    public function ruedas(): int
    {
        return 4;
    }

    public function describir(): string
    {
        return parent::describir() . " y {$this->puertas} puertas";
    }
}

class Moto extends Vehiculo
{
    public function ruedas(): int
    {
        return 2;
    }
}

class Camion extends Vehiculo
{
    public function __construct(string $marca, string $modelo, private int $ejes)
    {
        parent::__construct($marca, $modelo);
    }

    public function ruedas(): int
    {
        return $this->ejes * 4;
    }
}

$garaje = [
    new Coche("Seat", "Ibiza", 3),
    new Moto("Honda", "PCX"),
    new Camion("Volvo", "FH", 3),
];
$totalRuedas = 0;

foreach ($garaje as $vehiculo) {
    $totalRuedas += $vehiculo->ruedas();
}

foreach ($garaje as $vehiculo) {
    echo $vehiculo->describir() . "<br>";
}
echo "<strong>Ruedas en el garaje: {$totalRuedas}</strong>";
