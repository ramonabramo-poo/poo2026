<?php
$edad = 70;
$esMiercoles = false;
$precio = 9;

if ($edad < 4) {
    $precio = 0;
} elseif ($edad < 14 || $edad >= 65) {
    $precio = 6;
} elseif ($esMiercoles) {
    $precio = 5;
}

echo "Con $edad años, la entrada cuesta $precio €";
