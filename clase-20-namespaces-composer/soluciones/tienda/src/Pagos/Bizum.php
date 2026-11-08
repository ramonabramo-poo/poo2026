<?php
declare(strict_types=1);

namespace Tienda\Pagos;

use function Tienda\euros;

class Bizum implements MetodoPago
{
    public function cobrar(float $importe): string
    {
        return "Cobrados " . euros($importe) . " por Bizum";
    }
}
