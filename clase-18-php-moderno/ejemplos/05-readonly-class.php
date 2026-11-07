<?php
declare(strict_types=1);

// readonly class (PHP 8.2): TODAS sus propiedades son readonly.
// El objeto no puede cambiar nunca: es INMUTABLE.
readonly class Dinero
{
    public function __construct(
        public int $centimos,          // guardamos céntimos para no perder decimales
        public string $moneda = "EUR",
    ) {
    }

    public static function euros(float $cantidad): Dinero
    {
        return new Dinero((int) round($cantidad * 100));
    }

    // Como no se puede cambiar, "sumar" devuelve un objeto NUEVO
    public function sumar(Dinero $otro): Dinero
    {
        return new Dinero($this->centimos + $otro->centimos, $this->moneda);
    }

    public function formato(): string
    {
        return number_format($this->centimos / 100, 2, ",", ".") . " €";
    }
}

$precio = Dinero::euros(19.99);
$envio = Dinero::euros(4.95);
$total = $precio->sumar($envio);

echo "Precio: {$precio->formato()}<br>";
echo "Envío: {$envio->formato()}<br>";
echo "Total: {$total->formato()}<br>";          // 24,94 €
echo "El precio sigue siendo {$precio->formato()}<br>";   // no ha cambiado

try {
    $precio->centimos = 1;
} catch (Error $e) {
    echo "Error: {$e->getMessage()}";
}
