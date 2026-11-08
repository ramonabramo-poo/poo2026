<?php
declare(strict_types=1);

$hoy = new DateTime("today");
$vacaciones = new DateTime(date("Y") . "-12-22");

if ($vacaciones < $hoy) {
    $vacaciones->modify("+1 year");
}

$faltan = $hoy->diff($vacaciones)->days;
echo "Faltan {$faltan} días para las vacaciones de Navidad (" . $vacaciones->format("d/m/Y") . ")";
