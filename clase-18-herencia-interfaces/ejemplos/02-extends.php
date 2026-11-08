<?php
declare(strict_types=1);

// La clase PADRE: lo que tienen en común todos los usuarios
class Usuario
{
    public function __construct(
        public string $nombre,
        public string $email,
    ) {
    }

    public function saludar(): string
    {
        return "Hola, soy {$this->nombre} ({$this->email})";
    }
}

// Las clases HIJAS heredan todo lo del padre... y añaden lo suyo
class Alumno extends Usuario
{
    public float $nota = 0;

    public function haAprobado(): bool
    {
        return $this->nota >= 5;
    }
}

class Profesor extends Usuario
{
    public string $especialidad = "";
}

$marta = new Alumno("Marta", "marta@ejemplo.com");   // usa el constructor del padre
$marta->nota = 8.5;

$ramon = new Profesor("Ramón", "ramon@alpe.es");
$ramon->especialidad = "PHP";

echo $marta->saludar() . "<br>";                     // heredado de Usuario
echo $ramon->saludar() . "<br>";                     // heredado de Usuario
echo $marta->haAprobado() ? "Marta aprueba<br>" : "Marta suspende<br>";   // propio de Alumno

// Un Alumno ES un Usuario
var_dump($marta instanceof Usuario);   // bool(true)
