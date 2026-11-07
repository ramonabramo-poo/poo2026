<?php
declare(strict_types=1);

// Lo mismo vale para propiedades y valores de retorno
class Alumno
{
    public function __construct(
        public string $nombre,
        public ?float $nota = null,     // todavía sin nota
    ) {
    }

    public function notaTexto(): string
    {
        return $this->nota === null ? "sin nota" : (string) $this->nota;
    }
}

// ?string: «un texto... o null». Para datos que pueden faltar.
function saludar(?string $apodo): string
{
    if ($apodo === null) {
        return "Hola, desconocido";
    }
    return "Hola, {$apodo}";
}

// int|float: tipo UNIÓN, «un entero o un decimal»
function doble(int|float $numero): int|float
{
    return $numero * 2;
}

echo saludar("Luisito") . "<br>";
echo saludar(null) . "<br>";

var_dump(doble(4));      // int(8)
echo "<br>";
var_dump(doble(2.5));    // float(5)
echo "<br>";

$carlos = new Alumno("Carlos");
echo "{$carlos->nombre}: {$carlos->notaTexto()}<br>";

// Quitad las // y veréis el TypeError: un string no es ni int ni float
// doble("4");
