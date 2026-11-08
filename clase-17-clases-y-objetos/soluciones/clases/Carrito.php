<?php
declare(strict_types=1);

// Un carrito GUARDA objetos Producto: objetos dentro de objetos
class Carrito
{
    // [nombre del producto => ["producto" => Producto, "unidades" => int]]
    private array $lineas = [];

    public function anadir(Producto $producto, int $unidades = 1): void
    {
        if ($unidades < 1) {
            throw new InvalidArgumentException("Hay que añadir al menos una unidad.");
        }
        $yaHabia = $this->lineas[$producto->nombre]["unidades"] ?? 0;
        if ($yaHabia + $unidades > $producto->getStock()) {
            throw new RuntimeException("No hay stock suficiente de {$producto->nombre}.");
        }
        $this->lineas[$producto->nombre] = ["producto" => $producto, "unidades" => $yaHabia + $unidades];
    }

    public function quitar(string $nombre): void
    {
        unset($this->lineas[$nombre]);
    }

    public function getLineas(): array
    {
        return $this->lineas;
    }

    public function numeroArticulos(): int
    {
        return array_sum(array_column($this->lineas, "unidades"));
    }

    public function total(): float
    {
        $total = 0;
        foreach ($this->lineas as $linea) {
            $total += $linea["producto"]->precioConIva() * $linea["unidades"];
        }
        return round($total, 2);
    }
}
