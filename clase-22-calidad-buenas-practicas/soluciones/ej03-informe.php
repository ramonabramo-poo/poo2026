<?php
declare(strict_types=1);

// Inversión de dependencias: el Informe depende de una INTERFAZ, no de dónde vienen los datos
interface FuenteDeVentas
{
    /** @return array<string, float> producto => importe */
    public function ventas(): array;
}

class VentasEnMemoria implements FuenteDeVentas
{
    public function ventas(): array
    {
        return ["Camiseta" => 450.0, "Taza" => 119.25, "Gorra" => 95.0];
    }
}

class VentasDesdeCsv implements FuenteDeVentas
{
    public function __construct(private string $contenidoCsv)
    {
    }

    public function ventas(): array
    {
        $ventas = [];
        foreach (explode("\n", trim($this->contenidoCsv)) as $linea) {
            [$producto, $importe] = explode(";", $linea);
            $ventas[$producto] = ($ventas[$producto] ?? 0) + (float) $importe;
        }
        return $ventas;
    }
}

class Informe
{
    public function __construct(private FuenteDeVentas $fuente)
    {
    }

    public function masVendido(): string
    {
        $ventas = $this->fuente->ventas();
        arsort($ventas);
        return (string) array_key_first($ventas);
    }

    public function total(): float
    {
        return array_sum($this->fuente->ventas());
    }
}

$deMemoria = new Informe(new VentasEnMemoria());
$deCsv = new Informe(new VentasDesdeCsv("Taza;7.95\nLibro;24.90\nTaza;7.95\nLibro;24.90"));

echo "Memoria: más vendido {$deMemoria->masVendido()}, total {$deMemoria->total()} €<br>";
echo "CSV: más vendido {$deCsv->masVendido()}, total {$deCsv->total()} €";
