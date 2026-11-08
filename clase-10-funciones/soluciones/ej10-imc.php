<?php
declare(strict_types=1);

function imc(float $peso, float $altura): float
{
    return round($peso / ($altura ** 2), 1);
}

function categoriaImc(float $imc): string
{
    return match (true) {
        $imc < 18.5 => "bajo peso",
        $imc < 25 => "peso normal",
        $imc < 30 => "sobrepeso",
        default => "obesidad",
    };
}

$personas = [
    ["nombre" => "Ana", "peso" => 58, "altura" => 1.68],
    ["nombre" => "Iván", "peso" => 92, "altura" => 1.80],
];

foreach ($personas as $persona) {
    $valor = imc($persona["peso"], $persona["altura"]);
    echo "{$persona["nombre"]}: IMC $valor (" . categoriaImc($valor) . ")<br>";
}
