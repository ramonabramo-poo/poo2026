<?php
// Una constante es una caja "grabada en piedra": no cambia durante la ejecución.
// No lleva $ y, por convenio, se escribe en MAYÚSCULAS.

const IVA = 0.21;                      // forma recomendada
define("NOMBRE_TIENDA", "La Tiendita"); // forma clásica, también válida

$precio = 100;
echo "Bienvenidos a " . NOMBRE_TIENDA . "<br>";
echo "Precio con IVA: " . $precio * (1 + IVA) . " €<br>";

// Si intentáis cambiarla, PHP os para los pies.
// Quitad las dos barras de la línea siguiente y veréis el error:
// IVA = 0.10;
