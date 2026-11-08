<?php
// Ternarios anidados: PHP 8 exige paréntesis... y aun así se leen fatal
$nota = 6;

// ❌ $texto = $nota >= 9 ? "Sobresaliente" : $nota >= 5 ? "Aprobado" : "Suspenso";
//    En PHP 8 esto es un error de sintaxis

// ✅ Funciona, pero cuesta leerlo
$texto = $nota >= 9 ? "Sobresaliente" : ($nota >= 5 ? "Aprobado" : "Suspenso");

// ✅✅ Mucho mejor con match (true)
$mejor = match (true) {
    $nota >= 9 => "Sobresaliente",
    $nota >= 5 => "Aprobado",
    default => "Suspenso",
};

echo "$texto / $mejor";
