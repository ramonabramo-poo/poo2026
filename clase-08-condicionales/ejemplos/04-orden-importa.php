<?php
// El orden importa: la condición más general se "come" a las demás
$nota = 9.5;

// ❌ Mal: un 9.5 también es >= 5, así que entra aquí y no sigue mirando
if ($nota >= 5) {
    $mal = "Aprobado";
} elseif ($nota >= 9) {
    $mal = "Sobresaliente";   // nunca llega
} else {
    $mal = "Suspenso";
}

// ✅ Bien: de la más exigente a la menos exigente
if ($nota >= 9) {
    $bien = "Sobresaliente";
} elseif ($nota >= 5) {
    $bien = "Aprobado";
} else {
    $bien = "Suspenso";
}

echo "Orden incorrecto: $mal<br>";
echo "Orden correcto: $bien";
