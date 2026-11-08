<?php
declare(strict_types=1);

function validarEdad(string $edad): int
{
    if (!is_numeric($edad)) {
        throw new InvalidArgumentException("«{$edad}» no es un número");
    }
    $numero = (int) $edad;
    if ($numero < 0 || $numero > 120) {
        throw new InvalidArgumentException("$numero no es una edad posible");
    }

    return $numero;
}

$pruebas = ["34", "abc", "-5", "200", "18"];

foreach ($pruebas as $prueba) {
    try {
        $edad = validarEdad($prueba);
        echo "✅ $edad años<br>";
    } catch (InvalidArgumentException $error) {
        echo "❌ " . htmlspecialchars($error->getMessage()) . "<br>";
    }
}
