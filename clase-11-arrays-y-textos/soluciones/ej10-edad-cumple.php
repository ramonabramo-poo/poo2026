<?php
declare(strict_types=1);

$nacimiento = new DateTime("1995-03-14");
$hoy = new DateTime("today");

$edad = $nacimiento->diff($hoy)->y;

// El próximo cumpleaños: este año o, si ya ha pasado, el siguiente
$cumple = new DateTime(date("Y") . $nacimiento->format("-m-d"));
if ($cumple < $hoy) {
    $cumple->modify("+1 year");
}

$diasSemana = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
$diaCumple = $diasSemana[(int) $cumple->format("w")];   // "w": 0 = domingo … 6 = sábado

echo "Tienes $edad años.<br>";
echo "Tu próximo cumpleaños es el " . $cumple->format("d/m/Y") . ", que cae en $diaCumple.";
