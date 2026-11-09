<?php

namespace App\Servicios;

use App\Contracts\ConversorMoneda;
use InvalidArgumentException;

// Ejercicio 06: convierte con los cambios que le pasamos al crearlo (de config/academia.php)
class ConversorFijo implements ConversorMoneda
{
    private const NOMBRES = [
        'USD' => 'dólares',
        'GBP' => 'libras',
        'CHF' => 'francos suizos',
    ];

    public function __construct(private array $cambios)
    {
    }

    public function monedas(): array
    {
        return array_intersect_key(self::NOMBRES, $this->cambios);
    }

    public function convertir(float $euros, string $moneda): float
    {
        if (! isset($this->cambios[$moneda])) {
            throw new InvalidArgumentException("No sé convertir a {$moneda}.");
        }

        return round($euros * $this->cambios[$moneda], 2);
    }
}
