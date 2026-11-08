<?php
// Probad: ej12-imc.php?peso=70&altura=1.75
$peso = (float) ($_GET["peso"] ?? 0);
$altura = (float) ($_GET["altura"] ?? 0);

if ($peso <= 0 || $altura <= 0) {
    $mensaje = "Indicad el peso y la altura en la URL: ?peso=70&altura=1.75";
} else {
    $imc = $peso / ($altura * $altura);
    $categoria = match (true) {
        $imc < 18.5 => "bajo peso",
        $imc < 25 => "peso normal",
        $imc < 30 => "sobrepeso",
        default => "obesidad",
    };
    $mensaje = "IMC " . number_format($imc, 1, ",", ".") . ": $categoria";
}

echo $mensaje;
