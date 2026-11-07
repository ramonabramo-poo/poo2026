<?php
declare(strict_types=1);

// La CLASE es el molde: dice qué datos tendrá cada producto
class Producto
{
    public string $nombre = "";
    public float $precio = 0;
}

// Cada OBJETO es una galleta hecha con ese molde
$camiseta = new Producto();
$camiseta->nombre = "Camiseta";
$camiseta->precio = 15;

$gorra = new Producto();
$gorra->nombre = "Gorra";
$gorra->precio = 9.5;

echo "{$camiseta->nombre}: {$camiseta->precio} €<br>";
echo "{$gorra->nombre}: {$gorra->precio} €<br>";

// Dos objetos distintos, cada uno con sus propios datos
var_dump($camiseta);
