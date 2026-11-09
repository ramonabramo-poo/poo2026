<?php

namespace App\Contracts;

// Ejercicio 06: otro contrato. Hoy, con cambios fijos; mañana, quizá con una API
interface ConversorMoneda
{
    // Las monedas que sabe convertir: ['USD' => 'dólares', ...]
    public function monedas(): array;

    public function convertir(float $euros, string $moneda): float;
}
