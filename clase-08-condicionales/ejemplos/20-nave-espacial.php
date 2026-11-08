<?php
// <=> (nave espacial): compara y devuelve -1, 0 o 1
$miNota = 7;
$notaDeAna = 8;

$resultado = $miNota <=> $notaDeAna;

$mensaje = match ($resultado) {
    -1 => "Ana tiene más nota",
    0 => "Empate",
    1 => "Tengo más nota que Ana",
};

echo "$miNota <=> $notaDeAna da $resultado: $mensaje";
