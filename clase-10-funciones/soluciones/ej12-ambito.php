<?php
declare(strict_types=1);

// ❌ No funciona: $contador de dentro es OTRA variable, no la de fuera
function incrementarMal(): void
{
    $contador = 1;
    $contador++;
}

// ✅ Bien: recibe el valor y devuelve el nuevo
function incrementar(int $valor, int $paso = 1): int
{
    return $valor + $paso;
}

$contador = 0;
incrementarMal();
echo "Después de incrementarMal(): $contador<br>";   // 0

$contador = incrementar($contador);
$contador = incrementar($contador, paso: 5);
echo "Después de incrementar() dos veces: $contador";   // 6
