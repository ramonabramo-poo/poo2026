<?php
declare(strict_types=1);

function esBisiesto(int $anio): bool
{
    return ($anio % 4 === 0 && $anio % 100 !== 0) || $anio % 400 === 0;
}

// Una función puede usar otra: así cada una hace una sola cosa
function diasDelMes(int $mes, int $anio): int
{
    return match ($mes) {
        4, 6, 9, 11 => 30,
        2 => esBisiesto($anio) ? 29 : 28,
        default => 31,
    };
}

echo "Febrero de 2024: " . diasDelMes(2, 2024) . " días<br>";
echo "Febrero de 2026: " . diasDelMes(2, 2026) . " días<br>";
echo "Abril de 2026: " . diasDelMes(4, 2026) . " días";
