<?php
declare(strict_types=1);

// ?int: devuelve un entero... o null si no hay ningún número
function maximo(array $numeros): ?int
{
    if (count($numeros) === 0) {
        return null;
    }

    $mayor = $numeros[0];
    foreach ($numeros as $numero) {
        if ($numero > $mayor) {
            $mayor = $numero;
        }
    }

    return $mayor;
}

$listas = [[4, 17, 9], [-3, -8], []];

foreach ($listas as $lista) {
    $resultado = maximo($lista);
    echo "[" . implode(", ", $lista) . "] → " . ($resultado ?? "no hay números") . "<br>";
}
