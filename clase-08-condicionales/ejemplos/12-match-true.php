<?php
// match (true): cada brazo es una condición; gana la primera que sea verdadera
$imc = 26.4;

$categoria = match (true) {
    $imc < 18.5 => "Bajo peso",
    $imc < 25 => "Peso normal",
    $imc < 30 => "Sobrepeso",
    default => "Obesidad",
};

echo "Con un IMC de $imc: $categoria";
