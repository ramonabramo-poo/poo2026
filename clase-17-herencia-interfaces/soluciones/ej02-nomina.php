<?php
declare(strict_types=1);

abstract class Empleado
{
    public function __construct(public readonly string $nombre)
    {
    }

    abstract public function sueldoMensual(): float;

    abstract public function tipo(): string;
}

class EmpleadoFijo extends Empleado
{
    public function __construct(string $nombre, private float $salarioAnual)
    {
        parent::__construct($nombre);
    }

    public function sueldoMensual(): float
    {
        return round($this->salarioAnual / 12, 2);
    }

    public function tipo(): string
    {
        return "Fijo";
    }
}

class EmpleadoPorHoras extends Empleado
{
    public function __construct(string $nombre, private int $horas, private float $precioHora)
    {
        parent::__construct($nombre);
    }

    public function sueldoMensual(): float
    {
        return round($this->horas * $this->precioHora, 2);
    }

    public function tipo(): string
    {
        return "Por horas";
    }
}

final class Becario extends Empleado
{
    private const AYUDA = 600;

    public function sueldoMensual(): float
    {
        return self::AYUDA;
    }

    public function tipo(): string
    {
        return "Becario";
    }
}

function euros(float $cantidad): string
{
    return number_format($cantidad, 2, ",", ".") . " €";
}

$plantilla = [
    new EmpleadoFijo("Ana García", 30000),
    new EmpleadoPorHoras("Luis Pérez", 80, 15.5),
    new Becario("Sara López"),
];
$total = 0;

foreach ($plantilla as $empleado) {
    $total += $empleado->sueldoMensual();   // polimorfismo: cada uno calcula a su manera
}
?>
<table border="1" cellpadding="6">
    <tr><th>Empleado</th><th>Tipo</th><th>Sueldo del mes</th></tr>
    <?php foreach ($plantilla as $empleado): ?>
        <tr>
            <td><?= htmlspecialchars($empleado->nombre) ?></td>
            <td><?= $empleado->tipo() ?></td>
            <td><?= euros($empleado->sueldoMensual()) ?></td>
        </tr>
    <?php endforeach; ?>
    <tr><th colspan="2">Total</th><th><?= euros($total) ?></th></tr>
</table>
