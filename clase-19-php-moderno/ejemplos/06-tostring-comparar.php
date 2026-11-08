<?php
declare(strict_types=1);

class Producto
{
    public function __construct(public string $nombre, public float $precio)
    {
    }

    // __toString: lo que se muestra al hacer echo del objeto
    public function __toString(): string
    {
        return "{$this->nombre} (" . number_format($this->precio, 2, ",", ".") . " €)";
    }
}

$taza1 = new Producto("Taza", 7.95);
$taza2 = new Producto("Taza", 7.95);
$mismaTaza = $taza1;           // ¡no es una copia! Es OTRO NOMBRE para el mismo objeto
$copia = clone $taza1;         // esto sí es una copia independiente

echo "Producto: {$taza1}<br>";   // gracias a __toString

// == : ¿tienen los mismos datos?   === : ¿son EL MISMO objeto?
var_dump($taza1 == $taza2);      // bool(true)  → mismos datos
var_dump($taza1 === $taza2);     // bool(false) → dos objetos distintos
var_dump($taza1 === $mismaTaza); // bool(true)  → el mismo objeto
echo "<br>";

$mismaTaza->precio = 9.95;       // cambiamos "la otra"...
$copia->precio = 5;
echo "taza1: {$taza1}<br>";      // ...¡y ha cambiado taza1! (9,95 €)
echo "copia: {$copia}<br>";      // la copia va por libre (5,00 €)
