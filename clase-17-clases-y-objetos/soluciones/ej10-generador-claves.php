<?php
declare(strict_types=1);

class GeneradorClave
{
    const LETRAS = "abcdefghijkmnpqrstuvwxyz";
    const MAYUSCULAS = "ABCDEFGHJKLMNPQRSTUVWXYZ";
    const NUMEROS = "23456789";   // sin 0, 1, l ni O: se confunden

    // Estático: no hace falta crear un generador para usarlo
    public static function generar(int $longitud = 10): string
    {
        if ($longitud < 6) {
            throw new InvalidArgumentException("Mínimo 6 caracteres");
        }

        $caracteres = self::LETRAS . self::MAYUSCULAS . self::NUMEROS;
        $clave = "";
        for ($i = 0; $i < $longitud; $i++) {
            $clave .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }

        return $clave;
    }
}

for ($i = 1; $i <= 3; $i++) {
    echo GeneradorClave::generar(12) . "<br>";
}
