<?php
declare(strict_types=1);

class CuentaBancaria
{
    private float $saldo = 0;
    private array $movimientos = [];

    public function __construct(
        public readonly string $titular,
    ) {
    }

    public function ingresar(float $cantidad, string $concepto): void
    {
        $this->comprobarCantidad($cantidad);
        $this->saldo += $cantidad;
        $this->anotar($concepto, $cantidad);
    }

    public function retirar(float $cantidad, string $concepto): void
    {
        $this->comprobarCantidad($cantidad);
        if ($cantidad > $this->saldo) {
            throw new RuntimeException("Saldo insuficiente para «{$concepto}».");
        }
        $this->saldo -= $cantidad;
        $this->anotar($concepto, -$cantidad);
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function getMovimientos(): array
    {
        return $this->movimientos;
    }

    // Métodos privados: ayudantes internos que nadie de fuera necesita ver
    private function comprobarCantidad(float $cantidad): void
    {
        if ($cantidad <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser positiva.");
        }
    }

    private function anotar(string $concepto, float $importe): void
    {
        $this->movimientos[] = ["concepto" => $concepto, "importe" => $importe, "saldo" => $this->saldo];
    }
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

$cuenta = new CuentaBancaria("Ana García");
$error = "";

$cuenta->ingresar(1200, "Nómina");
$cuenta->retirar(450, "Alquiler");
$cuenta->retirar(60.5, "Supermercado");
try {
    $cuenta->retirar(2000, "Moto nueva");
} catch (RuntimeException $e) {
    $error = $e->getMessage();
}
?>
<h1>Cuenta de <?= htmlspecialchars($cuenta->titular) ?></h1>
<table border="1" cellpadding="6">
    <tr><th>Concepto</th><th>Importe</th><th>Saldo</th></tr>
    <?php foreach ($cuenta->getMovimientos() as $movimiento): ?>
        <tr>
            <td><?= htmlspecialchars($movimiento["concepto"]) ?></td>
            <td><?= euros($movimiento["importe"]) ?></td>
            <td><?= euros($movimiento["saldo"]) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<p><strong>Saldo actual: <?= euros($cuenta->getSaldo()) ?></strong></p>
<?php if ($error !== ""): ?>
    <p style="color: #b00020">⚠️ <?= htmlspecialchars($error) ?></p>
<?php endif; ?>
