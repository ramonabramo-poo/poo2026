<?php
declare(strict_types=1);

class Cuenta
{
    protected float $saldo = 0;

    public function __construct(protected string $titular)
    {
    }

    public function ingresar(float $cantidad): void
    {
        $this->saldo += $cantidad;
    }

    public function retirar(float $cantidad): void
    {
        if ($cantidad > $this->saldo) {
            throw new RuntimeException("Saldo insuficiente");
        }
        $this->saldo -= $cantidad;
    }

    public function saldo(): float
    {
        return $this->saldo;
    }
}

class CuentaCorriente extends Cuenta
{
    public function __construct(string $titular, private float $descubierto = 300)
    {
        parent::__construct($titular);
    }

    // Puede quedarse en negativo hasta el límite del descubierto
    public function retirar(float $cantidad): void
    {
        if ($this->saldo - $cantidad < -$this->descubierto) {
            throw new RuntimeException("Supera el descubierto permitido");
        }
        $this->saldo -= $cantidad;
    }
}

class CuentaAhorro extends Cuenta
{
    const INTERES_ANUAL = 0.02;

    public function aplicarIntereses(): void
    {
        $this->ingresar(round($this->saldo * self::INTERES_ANUAL, 2));
    }
}

$corriente = new CuentaCorriente("Lucía");
$ahorro = new CuentaAhorro("Lucía");
$corriente->ingresar(100);
$ahorro->ingresar(1000);

$corriente->retirar(250);           // se queda en -150: permitido
$ahorro->aplicarIntereses();

foreach (["Corriente" => $corriente, "Ahorro" => $ahorro] as $tipo => $cuenta) {
    echo "$tipo: " . number_format($cuenta->saldo(), 2, ",", ".") . " €<br>";
    try {
        $cuenta->retirar(2000);
    } catch (RuntimeException $error) {
        echo "&nbsp;&nbsp;❌ No puede retirar 2.000 €: " . $error->getMessage() . "<br>";
    }
}
