<?php
declare(strict_types=1);

interface MetodoPago
{
    public function nombre(): string;

    public function comision(float $importe): float;

    public function admite(float $importe): bool;
}

class Tarjeta implements MetodoPago
{
    public function nombre(): string
    {
        return "Tarjeta";
    }

    public function comision(float $importe): float
    {
        return round($importe * 0.01, 2);
    }

    public function admite(float $importe): bool
    {
        return true;
    }
}

class Bizum implements MetodoPago
{
    const MAXIMO = 1000;

    public function nombre(): string
    {
        return "Bizum";
    }

    public function comision(float $importe): float
    {
        return 0;
    }

    public function admite(float $importe): bool
    {
        return $importe <= self::MAXIMO;
    }
}

class Transferencia implements MetodoPago
{
    public function nombre(): string
    {
        return "Transferencia";
    }

    public function comision(float $importe): float
    {
        return 1.50;
    }

    public function admite(float $importe): bool
    {
        return $importe >= 10;
    }
}

// Funciona con CUALQUIER método de pago: solo le importa el contrato
function cobrar(MetodoPago $metodo, float $importe): string
{
    if (!$metodo->admite($importe)) {
        return "{$metodo->nombre()}: no admite " . number_format($importe, 2, ",", ".") . " €";
    }
    $total = $importe + $metodo->comision($importe);
    return "{$metodo->nombre()}: " . number_format($total, 2, ",", ".") . " € (comisión incluida)";
}

foreach ([new Tarjeta(), new Bizum(), new Transferencia()] as $metodo) {
    echo cobrar($metodo, 1200) . "<br>";
}
