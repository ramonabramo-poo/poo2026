<?php
declare(strict_types=1);

class Alumno
{
    public function __construct(
        public readonly int $id,      // se asigna una vez y ya no cambia
        public string $nombre,
        private float $nota = 0,
    ) {
    }

    public function getNota(): float
    {
        return $this->nota;
    }

    // Un "setter": deja cambiar la nota, pero solo si es válida
    public function setNota(float $nota): void
    {
        if ($nota < 0 || $nota > 10) {
            throw new InvalidArgumentException("La nota debe estar entre 0 y 10.");
        }
        $this->nota = $nota;
    }

    public function haAprobado(): bool
    {
        return $this->nota >= 5;
    }
}

$marta = new Alumno(1, "Marta García");
$marta->setNota(8.5);
$marta->nombre = "Marta García López";    // public: se puede cambiar

echo "#{$marta->id} {$marta->nombre}: {$marta->getNota()}<br>";
echo $marta->haAprobado() ? "Aprobada<br>" : "Suspensa<br>";

try {
    $marta->setNota(15);
} catch (InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}<br>";
}

try {
    $marta->id = 99;    // readonly: no se puede
} catch (Error $e) {
    echo "Error: {$e->getMessage()}<br>";
}
