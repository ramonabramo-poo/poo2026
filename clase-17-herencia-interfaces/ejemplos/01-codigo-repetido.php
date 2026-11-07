<?php
declare(strict_types=1);

// Dos clases que se parecen MUCHO: el nombre, el email y saludar() están repetidos
class Alumno
{
    public function __construct(
        public string $nombre,
        public string $email,
        public float $nota,
    ) {
    }

    public function saludar(): string
    {
        return "Hola, soy {$this->nombre} ({$this->email})";
    }
}

class Profesor
{
    public function __construct(
        public string $nombre,
        public string $email,
        public string $especialidad,
    ) {
    }

    public function saludar(): string
    {
        return "Hola, soy {$this->nombre} ({$this->email})";
    }
}

$marta = new Alumno("Marta", "marta@ejemplo.com", 8.5);
$ramon = new Profesor("Ramón", "ramon@alpe.es", "PHP");

echo $marta->saludar() . "<br>";
echo $ramon->saludar() . "<br>";
// Si mañana cambia saludar(), hay que cambiarlo en DOS sitios... o en diez
