<?php
declare(strict_types=1);

enum Prioridad: string
{
    case Baja = "baja";
    case Media = "media";
    case Alta = "alta";

    public function icono(): string
    {
        return match ($this) {
            Prioridad::Baja => "🟢",
            Prioridad::Media => "🟡",
            Prioridad::Alta => "🔴",
        };
    }

    public function peso(): int
    {
        return match ($this) {
            Prioridad::Baja => 1,
            Prioridad::Media => 2,
            Prioridad::Alta => 3,
        };
    }
}

// Lo que llegaría de la base de datos o de un formulario: textos
$filas = [
    ["tarea" => "Corregir exámenes", "prioridad" => "alta"],
    ["tarea" => "Ordenar la mesa", "prioridad" => "baja"],
    ["tarea" => "Preparar la clase", "prioridad" => "media"],
    ["tarea" => "Algo raro", "prioridad" => "urgentísima"],
];

$tareas = [];
foreach ($filas as $fila) {
    // tryFrom devuelve null si el texto no es válido (from lanzaría un error)
    $prioridad = Prioridad::tryFrom($fila["prioridad"]);
    if ($prioridad === null) {
        echo "Ignoro «{$fila["tarea"]}»: prioridad desconocida<br>";
        continue;
    }
    $tareas[] = ["tarea" => $fila["tarea"], "prioridad" => $prioridad];
}

usort($tareas, fn (array $a, array $b): int => $b["prioridad"]->peso() <=> $a["prioridad"]->peso());

foreach ($tareas as $tarea) {
    echo "{$tarea["prioridad"]->icono()} {$tarea["tarea"]}<br>";
}
