<?php
declare(strict_types=1);

// Nuestras funciones pueden lanzar excepciones con throw
function retirarDinero(float $saldo, float $cantidad): float
{
    if ($cantidad <= 0) {
        throw new InvalidArgumentException("La cantidad debe ser positiva.");
    }
    if ($cantidad > $saldo) {
        throw new Exception("Saldo insuficiente: tienes {$saldo} €.");
    }
    return $saldo - $cantidad;
}

$saldo = 100;
$operaciones = [50, -10, 500];

// 1. Capturar un error que lanza PHP
try {
    echo intdiv(10, 0);                      // PHP lanza DivisionByZeroError
    echo "Esta línea no se ejecuta";
} catch (DivisionByZeroError $error) {
    echo "No se puede dividir entre cero.<br>";
}

// 2. Capturar las excepciones que lanza nuestra función
foreach ($operaciones as $cantidad) {
    try {
        $nuevoSaldo = retirarDinero($saldo, $cantidad);
        echo "Retirados {$cantidad} €. Saldo: {$nuevoSaldo} €<br>";
    } catch (InvalidArgumentException $e) {
        echo "Dato incorrecto: " . $e->getMessage() . "<br>";
    } catch (Exception $e) {
        echo "Operación rechazada: " . $e->getMessage() . "<br>";
    } finally {
        echo "<small>(operación de {$cantidad} € registrada)</small><br>";
    }
}
