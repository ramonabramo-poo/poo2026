<?php
// El fallo clásico de switch: olvidar un break
$opcion = 1;
$mensajes = "";

switch ($opcion) {
    case 1:
        $mensajes .= "Has elegido el 1. ";
        // ❌ falta el break: sigue con el caso 2
    case 2:
        $mensajes .= "Has elegido el 2. ";
        break;
    case 3:
        $mensajes .= "Has elegido el 3. ";
        break;
}

echo $mensajes;   // Has elegido el 1. Has elegido el 2.
