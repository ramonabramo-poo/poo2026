<?php
declare(strict_types=1);

namespace App\Modelos;

// Carbon es una librería externa, instalada con Composer: también se importa con use
use Carbon\Carbon;

class Pedido
{
    private array $lineas = [];
    private Carbon $fecha;

    public function __construct(public readonly int $numero, ?Carbon $fecha = null)
    {
        $this->fecha = $fecha ?? Carbon::now();
    }

    public function anadir(Producto $producto, int $unidades = 1): void
    {
        $this->lineas[] = ["producto" => $producto, "unidades" => $unidades];
    }

    public function total(): float
    {
        $total = 0;
        foreach ($this->lineas as $linea) {
            $total += $linea["producto"]->precioConIva() * $linea["unidades"];
        }
        return round($total, 2);
    }

    public function haceCuanto(): string
    {
        return $this->fecha->locale("es")->diffForHumans();             // "hace 3 días"
    }

    public function fechaEntrega(): string
    {
        $entrega = $this->fecha->copy()->addWeekdays(3);                // 3 días laborables
        return $entrega->locale("es")->isoFormat("dddd D [de] MMMM");   // "miércoles 11 de noviembre"
    }
}
