<?php
declare(strict_types=1);

use App\Modelos\Producto;
use App\Servicios\Carrito;

// La AUTOCARGA: cuando PHP encuentra una clase que no conoce, llama a esta función.
// Nosotros traducimos su nombre completo a la ruta del archivo y lo cargamos.
spl_autoload_register(function (string $clase): void {
    // "App\Servicios\Carrito"  →  "src/Servicios/Carrito.php"
    $prefijo = "App\\";
    if (!str_starts_with($clase, $prefijo)) {
        return;   // no es una de nuestras clases
    }
    $relativa = substr($clase, strlen($prefijo));
    $archivo = __DIR__ . "/src/" . str_replace("\\", "/", $relativa) . ".php";

    echo "<small>🔎 Cargando {$clase} desde src/" . str_replace("\\", "/", $relativa) . ".php</small><br>";
    if (file_exists($archivo)) {
        require $archivo;
    }
});

// Ni un solo require de clases: se cargan solas la primera vez que se usan
$carrito = new Carrito();
$carrito->anadir(new Producto("Camiseta", 15));
$carrito->anadir(new Producto("Taza", 7.95));

echo "<p>{$carrito->cuantos()} productos · Total: {$carrito->total()} €</p>";
