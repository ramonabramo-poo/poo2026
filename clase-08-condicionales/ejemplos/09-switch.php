<?php
// switch: la forma clásica de elegir según un valor (compara con ==)
$dia = "sábado";

switch ($dia) {
    case "lunes":
    case "martes":
    case "miércoles":
    case "jueves":
    case "viernes":
        $plan = "A clase";
        break;           // sin break, seguiría ejecutando el caso siguiente
    case "sábado":
        $plan = "Repasar los ejercicios";
        break;
    case "domingo":
        $plan = "Descansar";
        break;
    default:
        $plan = "Ese día no existe";
}

echo "El $dia toca: $plan";
