<?php
declare(strict_types=1);

trait ConRegistro
{
    private array $registro = [];

    protected function registrar(string $accion): void
    {
        $this->registro[] = date("H:i:s") . " · " . $accion;
    }

    public function historial(): array
    {
        return $this->registro;
    }
}

class Usuario
{
    use ConRegistro;

    public function __construct(private string $nombre)
    {
        $this->registrar("Alta de {$nombre}");
    }

    public function cambiarNombre(string $nuevo): void
    {
        $this->registrar("Nombre cambiado de {$this->nombre} a {$nuevo}");
        $this->nombre = $nuevo;
    }
}

class Pedido
{
    use ConRegistro;

    private string $estado = "nuevo";

    public function cambiarEstado(string $estado): void
    {
        $this->registrar("Pedido: {$this->estado} → {$estado}");
        $this->estado = $estado;
    }
}

$usuario = new Usuario("lucia");
$usuario->cambiarNombre("lucia.perez");
$pedido = new Pedido();
$pedido->cambiarEstado("pagado");
$pedido->cambiarEstado("enviado");

echo implode("<br>", array_merge($usuario->historial(), $pedido->historial()));
