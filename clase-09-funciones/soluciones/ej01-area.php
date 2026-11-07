<?php
declare(strict_types=1);

function areaRectangulo(float $base, float $altura): float
{
    return $base * $altura;
}

function areaCirculo(float $radio): float
{
    return round(M_PI * $radio ** 2, 2);
}

echo "Rectángulo 4 x 2,5: " . areaRectangulo(4, 2.5) . "<br>";   // 10
echo "Círculo de radio 3: " . areaCirculo(3);                      // 28.27
