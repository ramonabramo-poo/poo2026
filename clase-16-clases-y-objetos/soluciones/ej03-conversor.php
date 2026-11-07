<?php
declare(strict_types=1);

// Una clase "de utilidades": solo métodos estáticos, no hace falta crear objetos
class Conversor
{
    public const KM_POR_MILLA = 1.609344;

    public static function celsiusAFahrenheit(float $celsius): float
    {
        return round($celsius * 9 / 5 + 32, 1);
    }

    public static function fahrenheitACelsius(float $fahrenheit): float
    {
        return round(($fahrenheit - 32) * 5 / 9, 1);
    }

    public static function millasAKm(float $millas): float
    {
        return round($millas * self::KM_POR_MILLA, 2);
    }
}

echo "20 ºC = " . Conversor::celsiusAFahrenheit(20) . " ºF<br>";    // 68
echo "100 ºF = " . Conversor::fahrenheitACelsius(100) . " ºC<br>";  // 37.8
echo "26.2 millas = " . Conversor::millasAKm(26.2) . " km<br>";     // 42.16 (un maratón)
echo "1 milla son " . Conversor::KM_POR_MILLA . " km";
