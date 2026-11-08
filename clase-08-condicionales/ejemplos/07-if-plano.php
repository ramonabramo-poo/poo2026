<?php
// El mismo programa sin anidar: descartamos primero lo que no cumple
$edad = 19;
$teoricoAprobado = false;

if ($edad < 18) {
    $mensaje = "Todavía no tiene edad";
} elseif (!$teoricoAprobado) {
    $mensaje = "Tiene que aprobar el teórico";
} else {
    $mensaje = "Puede presentarse al práctico";
}

echo $mensaje;
