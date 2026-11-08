<?php
// Tres errores típicos con los bucles (y su arreglo)
$notas = [7, 4, 9];

// 1. Salirse del array: el último índice es count() - 1
for ($i = 0; $i < count($notas); $i++) {   // ✅ con <, no con <=
    echo "{$notas[$i]} ";
}
echo "<br>";

// 2. Poner el acumulador DENTRO del bucle: vuelve a 0 en cada vuelta
$suma = 0;                                   // ✅ antes del bucle
foreach ($notas as $nota) {
    $suma += $nota;
}
echo "Suma: $suma<br>";

// 3. Olvidar cambiar la condición del while: bucle infinito
$quedan = 3;
while ($quedan > 0) {
    echo "Quedan $quedan<br>";
    $quedan--;                               // ✅ sin esta línea, no acabaría nunca
}
