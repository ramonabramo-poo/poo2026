<?php
// Simulamos lo que va escribiendo el usuario con un array
$correcta = "patata";
$intentos = ["patata1", "Patata", "patata", "otra"];
$maximoIntentos = 3;

$numeroIntento = 0;
$acertado = false;

while ($numeroIntento < $maximoIntentos && $numeroIntento < count($intentos)) {
    $escrita = $intentos[$numeroIntento];
    $numeroIntento++;

    if ($escrita === $correcta) {
        $acertado = true;
        break;
    }

    echo "Intento $numeroIntento: «{$escrita}» no es correcta<br>";
}

echo $acertado
    ? "✅ Acceso concedido en el intento $numeroIntento"
    : "⛔ Cuenta bloqueada tras $maximoIntentos intentos";
