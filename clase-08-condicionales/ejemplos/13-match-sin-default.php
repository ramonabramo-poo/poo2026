<?php
// Si ningún brazo coincide y no hay default, match lanza un error
$mes = 13;

try {
    $estacion = match ($mes) {
        12, 1, 2 => "invierno",
        3, 4, 5 => "primavera",
        6, 7, 8 => "verano",
        9, 10, 11 => "otoño",
    };
    echo "Estación: $estacion";
} catch (\UnhandledMatchError $error) {
    // try/catch lo veremos a fondo en la clase 14; de momento, para enseñar el mensaje
    echo "Error: " . $error->getMessage();
}
