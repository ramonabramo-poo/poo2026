<?php
declare(strict_types=1);

abstract class Animal
{
    public function __construct(protected string $nombre)
    {
    }

    // Cada animal DEBE decir qué sonido hace
    abstract public function sonido(): string;

    public function presentarse(): string
    {
        return "Soy {$this->nombre} y hago «{$this->sonido()}»";
    }
}

class Perro extends Animal
{
    public function sonido(): string
    {
        return "guau";
    }
}

class Gato extends Animal
{
    public function sonido(): string
    {
        return "miau";
    }
}

class Vaca extends Animal
{
    public function sonido(): string
    {
        return "muuu";
    }

    // Sobrescribe y amplía el método del padre
    public function presentarse(): string
    {
        return parent::presentarse() . " y doy leche 🥛";
    }
}

$granja = [new Perro("Toby"), new Gato("Misi"), new Vaca("Lola")];

foreach ($granja as $animal) {
    echo $animal->presentarse() . "<br>";
}
