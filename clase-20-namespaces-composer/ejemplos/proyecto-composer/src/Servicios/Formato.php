<?php
declare(strict_types=1);

namespace App\Servicios;

class Formato
{
    public static function euros(float $cantidad): string
    {
        return number_format($cantidad, 2, ",", ".") . " €";
    }
}
