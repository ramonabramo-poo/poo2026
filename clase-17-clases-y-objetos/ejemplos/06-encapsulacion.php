<?php
declare(strict_types=1);

class CuentaBancaria
{
    // private: desde fuera de la clase NO se puede tocar
    public function __construct(
        public string $titular,
        private float $saldo = 0,
    ) {
    }

    public function ingresar(float $cantidad): void
    {
        if ($cantidad <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser positiva.");
        }
        $this->saldo += $cantidad;
    }

    public function retirar(float $cantidad): void
    {
        if ($cantidad <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser positiva.");
        }
        if ($cantidad > $this->saldo) {
            throw new RuntimeException("Saldo insuficiente.");
        }
        $this->saldo -= $cantidad;
    }

    // Un "getter": deja LEER el saldo, pero no cambiarlo
    public function getSaldo(): float
    {
        return $this->saldo;
    }
}

$cuenta = new CuentaBancaria("Ana García");
$cuenta->ingresar(100);
$cuenta->retirar(30);
echo "Saldo de {$cuenta->titular}: {$cuenta->getSaldo()} €<br>";   // 70 €

try {
    $cuenta->retirar(500);
} catch (RuntimeException $e) {
    echo "No se puede: {$e->getMessage()}<br>";
}

// Quitad las // y veréis el error: Cannot access private property
// $cuenta->saldo = 1000000;
