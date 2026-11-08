<?php
declare(strict_types=1);

use App\Nucleo\Auth;
use App\Nucleo\BaseDatos;
use App\Servicios\CalculadoraPrecios;

$contenedor->compartido(PDO::class, fn() => BaseDatos::conexion());
$contenedor->compartido(Auth::class, fn() => new Auth());

// Ejercicio 07: el contenedor no sabe qué IVA poner, así que le damos la receta
$contenedor->compartido(CalculadoraPrecios::class, fn() => new CalculadoraPrecios(0.21, 30));
