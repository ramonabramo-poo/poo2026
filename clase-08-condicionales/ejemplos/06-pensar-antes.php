<?php
// Primero en pseudocódigo, después en PHP (versión con ifs anidados)
$edad = 19;
$teoricoAprobado = false;

if ($edad >= 18) {
    if ($teoricoAprobado) {
        $mensaje = "Puede presentarse al práctico";
    } else {
        $mensaje = "Tiene que aprobar el teórico";
    }
} else {
    $mensaje = "Todavía no tiene edad";
}

echo $mensaje;
