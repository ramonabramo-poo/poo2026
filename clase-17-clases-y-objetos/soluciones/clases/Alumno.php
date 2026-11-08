<?php
declare(strict_types=1);

class Alumno
{
    public function __construct(
        public readonly int $id,
        public readonly string $nombre,
        private ?float $nota = null,
    ) {
        if ($nota !== null) {
            $this->setNota($nota);
        }
    }

    public static function desdeArray(array $fila): Alumno
    {
        $nota = $fila["nota"] === null ? null : (float) $fila["nota"];
        return new Alumno((int) $fila["id"], $fila["nombre"], $nota);
    }

    public function getNota(): ?float
    {
        return $this->nota;
    }

    public function setNota(float $nota): void
    {
        if ($nota < 0 || $nota > 10) {
            throw new InvalidArgumentException("La nota de {$this->nombre} no es válida.");
        }
        $this->nota = $nota;
    }

    public function tieneNota(): bool
    {
        return $this->nota !== null;
    }

    public function haAprobado(): bool
    {
        return $this->tieneNota() && $this->nota >= 5;
    }
}
