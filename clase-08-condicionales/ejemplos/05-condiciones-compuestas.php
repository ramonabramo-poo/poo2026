<?php
// && (y), || (o) y ! (no) para juntar varias condiciones
$edad = 17;
$conPermiso = true;
$esFinde = true;
$llueve = false;

// && : se tienen que cumplir LAS DOS
if ($edad >= 16 && $conPermiso) {
    echo "Puede ir de excursión<br>";
}

// || : basta con que se cumpla UNA
if ($esFinde || $edad < 6) {
    echo "No hay clase<br>";
}

// ! : da la vuelta a la condición
if (!$llueve) {
    echo "Salimos al patio<br>";
}

// Paréntesis para dejar claro qué va con qué
if (($esFinde || $edad < 6) && !$llueve) {
    echo "¡Al parque!";
}
