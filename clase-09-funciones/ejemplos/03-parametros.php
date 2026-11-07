<?php
// Parámetro con valor por defecto: si no lo pasáis, usa el 21 %
function calcularIva($importe, $tasa = 0.21)
{
    return $importe * $tasa;
}

echo calcularIva(100) . "<br>";         // 21
echo calcularIva(100, 0.10) . "<br>";   // 10

// Argumentos con nombre: indicamos qué es cada dato
echo calcularIva(tasa: 0.04, importe: 50) . "<br>";   // 2 (el orden da igual)

// Con varios parámetros por defecto, los nombres son muy cómodos
function saludar($nombre, $saludo = "Hola", $signo = "!")
{
    return "{$saludo}, {$nombre}{$signo}";
}

echo saludar("Ana") . "<br>";                    // Hola, Ana!
echo saludar("Ana", signo: "...") . "<br>";      // Hola, Ana...
