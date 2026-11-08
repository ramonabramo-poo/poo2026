<?php
declare(strict_types=1);

class Persona
{
    const MAYORIA_EDAD = 18;

    public function __construct(
        private string $nombre,
        private DateTimeImmutable $nacimiento,
    ) {
    }

    public function edad(): int
    {
        return $this->nacimiento->diff(new DateTimeImmutable("today"))->y;
    }

    public function esMayorDeEdad(): bool
    {
        return $this->edad() >= self::MAYORIA_EDAD;
    }

    public function describir(): string
    {
        $tipo = $this->esMayorDeEdad() ? "mayor" : "menor";
        return "{$this->nombre} tiene {$this->edad()} años ({$tipo} de edad)";
    }
}

$personas = [
    new Persona("Lucía", new DateTimeImmutable("1990-06-15")),
    new Persona("Hugo", new DateTimeImmutable("2012-02-01")),
];

foreach ($personas as $persona) {
    echo $persona->describir() . "<br>";
}
