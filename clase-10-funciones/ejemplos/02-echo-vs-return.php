<?php
// Función "impresora": muestra el resultado, pero no nos lo da
function sumarYMostrar($a, $b)
{
    echo $a + $b;
}

// Función "calculadora": nos DEVUELVE el resultado
function sumar($a, $b)
{
    return $a + $b;
}

sumarYMostrar(2, 3);        // muestra 5... y ya está
echo "<br>";

$total = sumar(2, 3);       // guardamos el 5 en una variable
$doble = sumar($total, $total);   // y lo podemos reutilizar
echo "El total es $total y el doble es $doble<br>";

// ¿Qué pasa si intentamos guardar lo que da la impresora?
$nada = sumarYMostrar(2, 3);   // muestra 5, pero...
echo "<br>";
var_dump($nada);               // NULL: no devolvió nada
