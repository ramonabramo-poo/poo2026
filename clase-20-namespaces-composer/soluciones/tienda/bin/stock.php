<?php
declare(strict_types=1);

// Ejercicio 10: un script de consola que también usa la autocarga
// Se ejecuta con: php bin/stock.php   o   composer stock
require __DIR__ . "/../vendor/autoload.php";

use Tienda\Catalogo\Categoria;
use Tienda\Catalogo\Producto;

$productos = [
    new Producto("Teclado", 49.90, Categoria::Informatica, 12),
    new Producto("Ratón", 19.90, Categoria::Informatica, 3),
    new Producto("Cuaderno", 2.50, Categoria::Papeleria, 0),
];

foreach ($productos as $producto) {
    $aviso = match (true) {
        $producto->stock() === 0 => "AGOTADO",
        $producto->stock() < 5 => "quedan pocos",
        default => "ok",
    };
    // mb_str_pad (PHP 8.3) cuenta bien las letras con tilde
    echo mb_str_pad($producto->nombre, 12) . mb_str_pad((string) $producto->stock(), 5, " ", STR_PAD_LEFT) . "  $aviso\n";
}
