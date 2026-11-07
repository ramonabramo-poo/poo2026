<?php
declare(strict_types=1);

// Una excepción PROPIA: hereda de una de PHP y añade sus datos
class SaldoInsuficienteException extends RuntimeException
{
    public function __construct(
        private float $saldo,
        private float $pedido,
    ) {
        parent::__construct("Saldo insuficiente: tienes {$saldo} € y quieres sacar {$pedido} €.");
    }

    public function getFalta(): float
    {
        return $this->pedido - $this->saldo;
    }
}

class CantidadNoValidaException extends InvalidArgumentException
{
}

class CuentaBancaria
{
    public function __construct(private float $saldo = 0)
    {
    }

    public function retirar(float $cantidad): void
    {
        if ($cantidad <= 0) {
            throw new CantidadNoValidaException("La cantidad debe ser positiva.");
        }
        if ($cantidad > $this->saldo) {
            throw new SaldoInsuficienteException($this->saldo, $cantidad);
        }
        $this->saldo -= $cantidad;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }
}

$cuenta = new CuentaBancaria(100);
$operaciones = [30, -5, 500];

foreach ($operaciones as $cantidad) {
    try {
        $cuenta->retirar($cantidad);
        echo "✅ Retirados {$cantidad} €. Saldo: {$cuenta->getSaldo()} €<br>";
    } catch (SaldoInsuficienteException $e) {
        // El nombre de la excepción ya dice qué ha pasado, y trae sus propios datos
        echo "❌ {$e->getMessage()} Te faltan {$e->getFalta()} €.<br>";
    } catch (CantidadNoValidaException $e) {
        echo "⚠️ {$e->getMessage()}<br>";
    }
}
