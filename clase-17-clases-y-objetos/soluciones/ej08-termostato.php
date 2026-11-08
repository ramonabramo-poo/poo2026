<?php
declare(strict_types=1);

class Termostato
{
    const MINIMA = 10;
    const MAXIMA = 30;

    private float $temperatura = 20;

    public function getTemperatura(): float
    {
        return $this->temperatura;
    }

    // El setter es el portero: no deja pasar valores imposibles
    public function setTemperatura(float $grados): void
    {
        if ($grados < self::MINIMA || $grados > self::MAXIMA) {
            throw new InvalidArgumentException("La temperatura debe estar entre " . self::MINIMA . " y " . self::MAXIMA . " ºC");
        }
        $this->temperatura = $grados;
    }

    public function subir(float $grados = 0.5): void
    {
        $this->setTemperatura($this->temperatura + $grados);
    }
}

$salon = new Termostato();
$salon->setTemperatura(22);
$salon->subir();
echo "Salón: {$salon->getTemperatura()} ºC<br>";

try {
    $salon->setTemperatura(45);
} catch (InvalidArgumentException $error) {
    echo "❌ " . $error->getMessage() . "<br>";
}
echo "Sigue a {$salon->getTemperatura()} ºC";
