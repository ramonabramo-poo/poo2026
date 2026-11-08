<?php
declare(strict_types=1);

interface Volador
{
    public function volar(): string;
}

interface Nadador
{
    public function nadar(): string;
}

// Una clase puede cumplir VARIOS contratos a la vez
class Pato implements Volador, Nadador
{
    public function volar(): string
    {
        return "El pato vuela bajito";
    }

    public function nadar(): string
    {
        return "El pato nada en el estanque";
    }
}

class Pez implements Nadador
{
    public function nadar(): string
    {
        return "El pez nada muy rápido";
    }
}

class Avion implements Volador
{
    public function volar(): string
    {
        return "El avión vuela a 10.000 metros";
    }
}

foreach ([new Pato(), new Pez(), new Avion()] as $cosa) {
    $nombre = get_class($cosa);
    $puede = [];
    if ($cosa instanceof Volador) {
        $puede[] = $cosa->volar();
    }
    if ($cosa instanceof Nadador) {
        $puede[] = $cosa->nadar();
    }
    echo "<strong>$nombre</strong>: " . implode(" · ", $puede) . "<br>";
}
