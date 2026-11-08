<?php
// El ordenador "piensa" un número y lo intenta adivinar a lo loco
$secreto = random_int(1, 20);
$intentos = 0;
$numero = 0;

while ($numero !== $secreto) {
    $numero = random_int(1, 20);
    $intentos++;
    echo "Intento $intentos: $numero<br>";
}

echo "<strong>¡Acertado! Era el $secreto. Ha necesitado $intentos intentos.</strong>";
