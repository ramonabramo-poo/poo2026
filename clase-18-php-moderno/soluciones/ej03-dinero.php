<?php
declare(strict_types=1);

readonly class Dinero
{
    public function __construct(public int $centimos)
    {
        if ($centimos < 0) {
            throw new InvalidArgumentException("No se admiten cantidades negativas.");
        }
    }

    public static function euros(float $cantidad): Dinero
    {
        return new Dinero((int) round($cantidad * 100));
    }

    public function sumar(Dinero $otro): Dinero
    {
        return new Dinero($this->centimos + $otro->centimos);
    }

    public function multiplicar(int $veces): Dinero
    {
        return new Dinero($this->centimos * $veces);
    }

    public function porcentaje(float $porcentaje): Dinero
    {
        return new Dinero((int) round($this->centimos * $porcentaje / 100));
    }

    public function __toString(): string
    {
        return number_format($this->centimos / 100, 2, ",", ".") . " €";
    }
}

$camiseta = Dinero::euros(15);
$taza = Dinero::euros(7.95);

$subtotal = $camiseta->multiplicar(2)->sumar($taza);
$iva = $subtotal->porcentaje(21);
$total = $subtotal->sumar($iva);

echo "2 camisetas + 1 taza: {$subtotal}<br>";   // 37,95 €
echo "IVA (21 %): {$iva}<br>";                 // 7,97 €
echo "<strong>Total: {$total}</strong><br>";   // 45,92 €
echo "La camiseta sigue costando {$camiseta}"; // inmutable: 15,00 €
