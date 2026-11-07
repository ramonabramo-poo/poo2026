<?php
declare(strict_types=1);

enum EstadoPedido: string
{
    case PENDIENTE = "pendiente";
    case ENVIADO = "enviado";
    case ENTREGADO = "entregado";
    case CANCELADO = "cancelado";

    // A qué estados se puede pasar desde cada uno
    public function siguientesPosibles(): array
    {
        return match ($this) {
            EstadoPedido::PENDIENTE => [EstadoPedido::ENVIADO, EstadoPedido::CANCELADO],
            EstadoPedido::ENVIADO => [EstadoPedido::ENTREGADO],
            EstadoPedido::ENTREGADO, EstadoPedido::CANCELADO => [],
        };
    }
}

class TransicionNoPermitidaException extends LogicException
{
    public function __construct(EstadoPedido $desde, EstadoPedido $hacia)
    {
        parent::__construct("Un pedido {$desde->value} no puede pasar a {$hacia->value}.");
    }
}

class Pedido
{
    private EstadoPedido $estado = EstadoPedido::PENDIENTE;
    private array $historial = [];

    public function __construct(public readonly int $numero)
    {
        $this->historial[] = $this->estado;
    }

    public function cambiarA(EstadoPedido $nuevo): void
    {
        if (!in_array($nuevo, $this->estado->siguientesPosibles(), true)) {
            throw new TransicionNoPermitidaException($this->estado, $nuevo);
        }
        $this->estado = $nuevo;
        $this->historial[] = $nuevo;
    }

    public function getEstado(): EstadoPedido
    {
        return $this->estado;
    }

    public function getHistorial(): array
    {
        return $this->historial;
    }
}

$pedido = new Pedido(1001);
$cambios = [EstadoPedido::ENVIADO, EstadoPedido::CANCELADO, EstadoPedido::ENTREGADO];
$avisos = [];

foreach ($cambios as $cambio) {
    try {
        $pedido->cambiarA($cambio);
    } catch (TransicionNoPermitidaException $e) {
        $avisos[] = $e->getMessage();
    }
}

echo "Pedido {$pedido->numero}: {$pedido->getEstado()->value}<br>";
echo "Historial: " . implode(" → ", array_map(fn(EstadoPedido $estado) => $estado->value, $pedido->getHistorial())) . "<br>";
foreach ($avisos as $aviso) {
    echo "⚠️ {$aviso}<br>";
}
