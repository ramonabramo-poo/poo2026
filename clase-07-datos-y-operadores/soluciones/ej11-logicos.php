<?php
$edad = 17;
$tieneCarnet = false;
$esEstudiante = true;

$puedeVotar = $edad >= 18;
$puedeConducir = $edad >= 18 && $tieneCarnet;
$tieneDescuento = $esEstudiante || $edad < 26 || $edad >= 65;
$necesitaAutorizacion = !$puedeVotar;

echo "¿Puede votar? " . ($puedeVotar ? "sí" : "no") . "<br>";
echo "¿Puede conducir? " . ($puedeConducir ? "sí" : "no") . "<br>";
echo "¿Tiene descuento (estudiante, joven o mayor)? " . ($tieneDescuento ? "sí" : "no") . "<br>";
echo "¿Necesita autorización de sus padres? " . ($necesitaAutorizacion ? "sí" : "no");
