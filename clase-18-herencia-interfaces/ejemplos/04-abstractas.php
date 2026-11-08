<?php
declare(strict_types=1);

// abstract: es un molde INCOMPLETO. No se pueden crear objetos Usuario a secas.
abstract class Usuario
{
    public function __construct(
        public string $nombre,
        public string $email,
    ) {
    }

    // Método abstracto: el padre dice QUÉ debe haber; cada hija decide CÓMO
    abstract public function obtenerRol(): string;

    public function presentarse(): string
    {
        return "{$this->nombre} · {$this->obtenerRol()}";
    }
}

class Alumno extends Usuario
{
    public function obtenerRol(): string
    {
        return "Alumno";
    }
}

class Profesor extends Usuario
{
    public function __construct(string $nombre, string $email, public string $especialidad)
    {
        parent::__construct($nombre, $email);
    }

    public function obtenerRol(): string
    {
        return "Docente de {$this->especialidad}";
    }
}

// final: nadie puede heredar de esta clase
final class Administrador extends Usuario
{
    public function obtenerRol(): string
    {
        return "Administración";
    }
}

$usuarios = [
    new Alumno("Marta", "marta@ejemplo.com"),
    new Profesor("Ramón", "ramon@alpe.es", "PHP"),
    new Administrador("Ana", "ana@alpe.es"),
];

foreach ($usuarios as $usuario) {
    echo $usuario->presentarse() . "<br>";
}

// Quitad las // y veréis el error: Cannot instantiate abstract class Usuario
// $nadie = new Usuario("Nadie", "nadie@ejemplo.com");
