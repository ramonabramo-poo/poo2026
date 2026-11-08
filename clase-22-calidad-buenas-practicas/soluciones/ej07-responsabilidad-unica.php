<?php
declare(strict_types=1);

// ANTES: una clase Pedido que calculaba, guardaba en un fichero Y enviaba el correo.
// Tres motivos para cambiar = tres responsabilidades. DESPUÉS: una clase para cada cosa.

class Pedido
{
    private array $lineas = [];

    public function __construct(public readonly string $cliente)
    {
    }

    public function anadir(string $producto, float $precio, int $unidades): void
    {
        $this->lineas[] = compact("producto", "precio", "unidades");
    }

    // Solo sabe de su dinero
    public function total(): float
    {
        return array_sum(array_map(fn (array $linea): float => $linea["precio"] * $linea["unidades"], $this->lineas));
    }

    public function lineas(): array
    {
        return $this->lineas;
    }
}

class PedidoRepositorioArchivo
{
    public function __construct(private string $archivo)
    {
    }

    // Solo sabe guardar
    public function guardar(Pedido $pedido): void
    {
        $datos = ["cliente" => $pedido->cliente, "lineas" => $pedido->lineas(), "total" => $pedido->total()];
        file_put_contents($this->archivo, json_encode($datos, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

class AvisoPedido
{
    // Solo sabe avisar (aquí lo mostramos; en la vida real, un correo)
    public function enviar(Pedido $pedido): string
    {
        return "Gracias, {$pedido->cliente}. Tu pedido de " . number_format($pedido->total(), 2, ",", ".") . " € está en marcha.";
    }
}

$pedido = new Pedido("Lucía");
$pedido->anadir("Teclado", 49.90, 1);
$pedido->anadir("Ratón", 19.90, 2);

(new PedidoRepositorioArchivo(sys_get_temp_dir() . "/pedidos.jsonl"))->guardar($pedido);
echo (new AvisoPedido())->enviar($pedido);
