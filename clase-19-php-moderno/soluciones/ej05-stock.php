<?php
declare(strict_types=1);

class StockInsuficienteException extends RuntimeException
{
    public function __construct(
        private string $producto,
        private int $disponibles,
        private int $pedidas,
    ) {
        parent::__construct("Solo quedan {$disponibles} unidades de {$producto} y has pedido {$pedidas}.");
    }

    public function getDisponibles(): int
    {
        return $this->disponibles;
    }
}

class ProductoNoEncontradoException extends RuntimeException
{
}

class Almacen
{
    // [nombre => unidades]
    public function __construct(private array $stock)
    {
    }

    public function sacar(string $producto, int $unidades): void
    {
        if (!isset($this->stock[$producto])) {
            throw new ProductoNoEncontradoException("No tenemos «{$producto}».");
        }
        if ($unidades > $this->stock[$producto]) {
            throw new StockInsuficienteException($producto, $this->stock[$producto], $unidades);
        }
        $this->stock[$producto] -= $unidades;
    }

    public function unidades(string $producto): int
    {
        return $this->stock[$producto] ?? 0;
    }
}

$almacen = new Almacen(["camiseta" => 10, "gorra" => 2]);
$pedidos = [["camiseta", 3], ["gorra", 5], ["paraguas", 1]];

// [$producto, $unidades] separa cada pedido en sus dos datos (desestructuración)
foreach ($pedidos as [$producto, $unidades]) {
    try {
        $almacen->sacar($producto, $unidades);
        echo "✅ {$unidades} x {$producto}. Quedan {$almacen->unidades($producto)}<br>";
    } catch (StockInsuficienteException $e) {
        // La excepción trae el dato que necesitamos para ofrecer una alternativa
        echo "❌ {$e->getMessage()} ¿Te llevas las {$e->getDisponibles()}?<br>";
    } catch (ProductoNoEncontradoException $e) {
        echo "🔍 {$e->getMessage()}<br>";
    }
}
