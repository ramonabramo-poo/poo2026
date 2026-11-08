<?php
declare(strict_types=1);

class Producto
{
    // Una constante de CLASE: pertenece al molde, no a cada galleta
    public const IVA = 0.21;

    // Una propiedad estática: la comparten TODOS los objetos
    private static int $creados = 0;

    public function __construct(
        public string $nombre,
        public float $precio,
    ) {
        self::$creados++;   // self:: = «esta clase»
    }

    public function precioConIva(): float
    {
        return round($this->precio * (1 + self::IVA), 2);
    }

    // Un método estático se llama desde la CLASE, sin crear ningún objeto
    public static function totalCreados(): int
    {
        return self::$creados;
    }
}

echo "IVA aplicado: " . Producto::IVA * 100 . " %<br>";   // la constante, desde fuera

$camiseta = new Producto("Camiseta", 15);
$gorra = new Producto("Gorra", 9.5);
$taza = new Producto("Taza", 7.95);

echo "{$taza->nombre}: {$taza->precioConIva()} €<br>";
echo "Productos creados: " . Producto::totalCreados();     // 3
