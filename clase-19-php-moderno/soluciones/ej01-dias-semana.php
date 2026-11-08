<?php
declare(strict_types=1);

enum DiaSemana: int
{
    case LUNES = 1;
    case MARTES = 2;
    case MIERCOLES = 3;
    case JUEVES = 4;
    case VIERNES = 5;
    case SABADO = 6;
    case DOMINGO = 7;

    public function nombre(): string
    {
        return match ($this) {
            DiaSemana::LUNES => "lunes",
            DiaSemana::MARTES => "martes",
            DiaSemana::MIERCOLES => "miércoles",
            DiaSemana::JUEVES => "jueves",
            DiaSemana::VIERNES => "viernes",
            DiaSemana::SABADO => "sábado",
            DiaSemana::DOMINGO => "domingo",
        };
    }

    public function esFinDeSemana(): bool
    {
        return $this === DiaSemana::SABADO || $this === DiaSemana::DOMINGO;
    }

    // date("N") devuelve el día de la semana del 1 (lunes) al 7 (domingo)
    public static function hoy(): DiaSemana
    {
        return DiaSemana::from((int) date("N"));
    }
}

date_default_timezone_set("Europe/Madrid");

$hoy = DiaSemana::hoy();

echo "Hoy es {$hoy->nombre()}" . ($hoy->esFinDeSemana() ? ": ¡fin de semana! 🎉" : ": toca clase 📚") . "<br><br>";
foreach (DiaSemana::cases() as $dia) {
    echo "{$dia->value}. {$dia->nombre()}" . ($dia->esFinDeSemana() ? " 🎉" : "") . "<br>";
}
