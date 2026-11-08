<?php
// Buscar un elemento: una "bandera" (variable booleana) que cambia si lo encontramos
$lista = ["pan", "leche", "huevos", "tomates", "aceite"];
$buscado = "huevos";
$encontrado = false;
$posicion = -1;

foreach ($lista as $indice => $producto) {
    if ($producto === $buscado) {
        $encontrado = true;
        $posicion = $indice;
        break;   // ya lo tenemos: no hace falta seguir mirando
    }
}

if ($encontrado) {
    echo "«{$buscado}» está en la posición $posicion";
} else {
    echo "«{$buscado}» no está en la lista";
}
