<?php
$a = 20;
$b = 0;
$operacion = "/";

switch ($operacion) {
    case "+":
        $resultado = $a + $b;
        break;
    case "-":
        $resultado = $a - $b;
        break;
    case "*":
        $resultado = $a * $b;
        break;
    case "/":
        // Antes de dividir, descartamos el caso problemático
        $resultado = $b === 0 ? "no se puede dividir entre cero" : $a / $b;
        break;
    default:
        $resultado = "operación desconocida";
}

echo "$a $operacion $b = $resultado";
