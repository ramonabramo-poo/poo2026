<?php
// El mismo problema, sin ifs dentro de ifs ("cláusulas de guarda"):
// primero descartamos los casos que no cumplen y al final queda el bueno.
$edad = 19;
$teoricoAprobado = false;

if ($edad < 18) {
    echo "Todavía no tiene edad";
} elseif (!$teoricoAprobado) {
    echo "Tiene que aprobar el teórico";
} else {
    echo "Puede presentarse al práctico";
}
