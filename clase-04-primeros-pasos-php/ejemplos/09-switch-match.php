<?php
$dia = "sábado";

// switch con llaves
switch ($dia) {
    case "sábado":
    case "domingo":
        echo "Fin de semana";
        break;
    default:
        echo "Día laborable";
}

echo "<br>";

// switch con sintaxis alternativa
switch ($dia):
    case "sábado":
    case "domingo":
        echo "Fin de semana";
        break;
    default:
        echo "Día laborable";
endswitch;

echo "<br>";

// match (PHP 8): compara con === y devuelve un valor
$codigo = 404;

$texto = match ($codigo) {
    200 => "Correcto",
    404 => "Página no encontrada",
    500 => "Error del servidor",
    default => "Código desconocido",
};
echo $texto;   // Página no encontrada
