<?php
declare(strict_types=1);

// Una familia de excepciones: todas son "errores de reserva"
class ReservaException extends RuntimeException
{
}

class FechaPasadaException extends ReservaException
{
}

class SinMesaException extends ReservaException
{
    public function __construct(int $personas, private array $alternativas)
    {
        parent::__construct("No hay mesa para $personas personas");
    }

    public function alternativas(): array
    {
        return $this->alternativas;
    }
}

function reservar(DateTimeImmutable $fecha, int $personas): string
{
    if ($fecha < new DateTimeImmutable("today")) {
        throw new FechaPasadaException("No se puede reservar en el pasado");
    }
    if ($personas > 8) {
        throw new SinMesaException($personas, ["dos mesas de 4", "el reservado (hasta 12)"]);
    }

    return "Mesa para $personas el " . $fecha->format("d/m/Y");
}

$pruebas = [["+3 days", 4], ["-1 day", 2], ["+1 week", 10]];

foreach ($pruebas as [$cuando, $personas]) {
    try {
        echo "✅ " . reservar(new DateTimeImmutable($cuando), $personas) . "<br>";
    } catch (SinMesaException $error) {
        // La más concreta primero
        echo "❌ {$error->getMessage()}. Os podemos ofrecer: " . implode(" o ", $error->alternativas()) . "<br>";
    } catch (ReservaException $error) {
        // Cualquier otro error de reserva
        echo "❌ {$error->getMessage()}<br>";
    }
}
