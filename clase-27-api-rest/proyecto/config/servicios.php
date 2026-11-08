<?php
declare(strict_types=1);

// Las "recetas" del contenedor. Lo que no aparece aquí, lo crea él solo (autowiring).

use App\Nucleo\Auth;
use App\Nucleo\BaseDatos;

$contenedor->compartido(PDO::class, fn() => BaseDatos::conexion());
$contenedor->compartido(Auth::class, fn() => new Auth());    // un único Auth para toda la petición
