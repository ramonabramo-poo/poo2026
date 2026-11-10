<?php
// Función sencilla
function saludar($nombre) {
    return "Hola, $nombre";
}

echo saludar("Carlos"), "<br>";   // Hola, Carlos
echo saludar("Elena"), "<br>";    // Hola, Elena

// Parámetro con valor por defecto
function calcularPrecio($base, $iva = 0.21) {
    return $base * (1 + $iva);
}

echo calcularPrecio(100), "<br>";         // 121 (usa el 21 %)
echo calcularPrecio(100, 0.10), "<br>";   // 110

// Declarar tipos
function sumar(int $a, int $b): int {
    return $a + $b;
}

function esMayorDeEdad(int $edad): bool {
    return $edad >= 18;
}

echo sumar(2, 3), "<br>";   // 5
var_dump(esMayorDeEdad(16));   // bool(false)
