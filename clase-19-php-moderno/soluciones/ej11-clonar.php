<?php
declare(strict_types=1);

class Presupuesto
{
    public array $lineas = [];

    public function __construct(public string $cliente)
    {
    }

    public function anadir(string $concepto, float $importe): void
    {
        $this->lineas[] = [$concepto, $importe];
    }

    public function total(): float
    {
        return array_sum(array_column($this->lineas, 1));
    }
}

$original = new Presupuesto("Lucía");
$original->anadir("Curso de PHP", 250);

// Asignar NO copia: las dos variables apuntan al mismo objeto
$mismo = $original;
$mismo->cliente = "Pablo";

// clone sí crea un objeto nuevo con los mismos datos
$copia = clone $original;
$copia->cliente = "Marta";
$copia->anadir("Curso de Laravel", 390);

echo "Original: {$original->cliente}, {$original->total()} €<br>";   // Pablo, 250
echo "Copia: {$copia->cliente}, {$copia->total()} €";               // Marta, 640
