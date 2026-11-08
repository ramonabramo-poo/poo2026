<?php
declare(strict_types=1);

class Libro
{
    private bool $prestado = false;

    public function __construct(
        public readonly string $isbn,
        public readonly string $titulo,
    ) {
    }

    public function estaPrestado(): bool
    {
        return $this->prestado;
    }

    public function prestar(): void
    {
        if ($this->prestado) {
            throw new RuntimeException("«{$this->titulo}» ya está prestado");
        }
        $this->prestado = true;
    }

    public function devolver(): void
    {
        $this->prestado = false;
    }
}

class Biblioteca
{
    private array $libros = [];   // isbn => Libro

    public function anadir(Libro $libro): void
    {
        $this->libros[$libro->isbn] = $libro;
    }

    public function prestar(string $isbn): void
    {
        $this->buscar($isbn)->prestar();
    }

    public function devolver(string $isbn): void
    {
        $this->buscar($isbn)->devolver();
    }

    public function disponibles(): array
    {
        return array_filter($this->libros, fn (Libro $libro): bool => !$libro->estaPrestado());
    }

    private function buscar(string $isbn): Libro
    {
        return $this->libros[$isbn] ?? throw new RuntimeException("No tenemos el libro $isbn");
    }
}

$biblioteca = new Biblioteca();
$biblioteca->anadir(new Libro("111", "El Quijote"));
$biblioteca->anadir(new Libro("222", "La Regenta"));
$biblioteca->anadir(new Libro("333", "Fortunata y Jacinta"));

$biblioteca->prestar("222");

try {
    $biblioteca->prestar("222");
} catch (RuntimeException $error) {
    echo "❌ " . $error->getMessage() . "<br>";
}

echo "Disponibles: " . implode(", ", array_map(fn (Libro $libro): string => $libro->titulo, $biblioteca->disponibles()));
