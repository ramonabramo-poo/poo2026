<?php
$edad = 20;
$tieneEntrada = true;
$esVip = false;

// && (Y): las dos condiciones deben cumplirse
if ($edad >= 18 && $tieneEntrada) {
    echo "Puede entrar al concierto<br>";
}

// || (O): basta con que se cumpla una
if ($esVip || $tieneEntrada) {
    echo "Tiene acceso<br>";
}

// ! (NO): da la vuelta al valor
if (!$esVip) {
    echo "No es VIP<br>";
}

// Precedencia: igual que en matemáticas, * va antes que +
echo 2 + 3 * 4;      // 14
echo "<br>";
echo (2 + 3) * 4;    // 20
echo "<br>";

// Mi consejo: cuando mezcléis && y ||, usad paréntesis siempre
$descuento = ($edad < 26 || $edad >= 65) && $tieneEntrada;
var_dump($descuento);   // bool(true)
