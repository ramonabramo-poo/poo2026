<?php
declare(strict_types=1);

class Usuario
{
    public function __construct(
        public string $nombre,
        protected string $email,    // protected: lo ven esta clase y sus hijas
    ) {
    }

    public function saludar(): string
    {
        return "Hola, soy {$this->nombre}";
    }
}

class Profesor extends Usuario
{
    // La hija tiene su propio constructor con un dato más...
    public function __construct(
        string $nombre,
        string $email,
        public string $especialidad,
    ) {
        // ...y llama al del padre para que haga su parte
        parent::__construct($nombre, $email);
    }

    // SOBRESCRIBIR: la hija cambia un método que ya tenía el padre
    public function saludar(): string
    {
        // parent::saludar() aprovecha lo que hacía el padre y lo amplía
        return parent::saludar() . " y enseño {$this->especialidad}";
    }

    public function contacto(): string
    {
        return "Escríbeme a {$this->email}";   // puede usar $email porque es protected
    }
}

$ramon = new Profesor("Ramón", "ramon@alpe.es", "PHP");

echo $ramon->saludar() . "<br>";    // Hola, soy Ramón y enseño PHP
echo $ramon->contacto() . "<br>";

// Quitad las // y veréis el error: desde FUERA, protected es como private
// echo $ramon->email;
