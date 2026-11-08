<?php

namespace App\Facades;

use App\Servicios\CalculadoraPrecios;
use Illuminate\Support\Facades\Facade;

/**
 * Nuestra propia fachada: Precios::conIva(100) llama a la CalculadoraPrecios del contenedor
 *
 * @method static float conIva(float $precio)
 * @method static float conDescuento(float $precio, int $porcentaje)
 * @method static string formatear(float $importe)
 */
class Precios extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CalculadoraPrecios::class;
    }
}
