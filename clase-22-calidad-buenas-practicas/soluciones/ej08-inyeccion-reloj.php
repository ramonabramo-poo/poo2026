<?php
declare(strict_types=1);

// Si la clase llamara a date("G") por dentro, ¿cómo probaríamos el saludo de la noche a las 10 de la mañana?
// Solución: inyectar el reloj.

interface Reloj
{
    public function hora(): int;
}

class RelojDelSistema implements Reloj
{
    public function hora(): int
    {
        return (int) date("G");
    }
}

// Un reloj "de mentira" para las pruebas: siempre dice la misma hora
class RelojFijo implements Reloj
{
    public function __construct(private int $hora)
    {
    }

    public function hora(): int
    {
        return $this->hora;
    }
}

class Saludador
{
    public function __construct(private Reloj $reloj)
    {
    }

    public function saludo(string $nombre): string
    {
        $hora = $this->reloj->hora();
        $saludo = match (true) {
            $hora >= 6 && $hora < 14 => "Buenos días",
            $hora >= 14 && $hora < 21 => "Buenas tardes",
            default => "Buenas noches",
        };
        return "$saludo, $nombre";
    }
}

echo (new Saludador(new RelojDelSistema()))->saludo("Lucía") . "<br>";

// Y ahora podemos probar todas las horas sin esperar a que lleguen
foreach ([9 => "Buenos días", 16 => "Buenas tardes", 23 => "Buenas noches"] as $hora => $esperado) {
    $obtenido = (new Saludador(new RelojFijo($hora)))->saludo("Ana");
    echo (str_starts_with($obtenido, $esperado) ? "✅" : "❌") . " a las $hora: $obtenido<br>";
}
