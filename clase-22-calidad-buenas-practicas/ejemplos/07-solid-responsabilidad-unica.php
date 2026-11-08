<?php
declare(strict_types=1);

// ❌ ANTES: una clase con TRES motivos para cambiar
// (las reglas de cálculo, el formato de salida y dónde se guarda)
class FacturaQueLoHaceTodo
{
    public function __construct(private array $lineas)
    {
    }

    public function total(): float
    {
        return array_sum(array_map(fn($l) => $l["precio"] * $l["cantidad"], $this->lineas));
    }

    public function imprimirHtml(): string
    {
        return "<p>Total: " . number_format($this->total(), 2, ",", ".") . " €</p>";
    }

    public function guardarEnFichero(string $ruta): void
    {
        file_put_contents($ruta, json_encode($this->lineas));
    }
}

// ✅ DESPUÉS: cada clase tiene UNA responsabilidad
class Factura
{
    public function __construct(public readonly array $lineas)
    {
    }

    public function total(): float
    {
        return array_sum(array_map(fn($l) => $l["precio"] * $l["cantidad"], $this->lineas));
    }
}

class FacturaHtml
{
    public function mostrar(Factura $factura): string
    {
        return "<p>Total: " . number_format($factura->total(), 2, ",", ".") . " €</p>";
    }
}

class FacturaRepositorio
{
    public function __construct(private string $carpeta)
    {
    }

    public function guardar(Factura $factura, int $numero): void
    {
        file_put_contents("{$this->carpeta}/factura-{$numero}.json", json_encode($factura->lineas));
    }
}

$factura = new Factura([["precio" => 15, "cantidad" => 2], ["precio" => 7.95, "cantidad" => 1]]);

echo (new FacturaQueLoHaceTodo($factura->lineas))->imprimirHtml();
echo (new FacturaHtml())->mostrar($factura);
