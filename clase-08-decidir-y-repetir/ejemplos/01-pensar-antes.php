<?php
// Problema: ¿puede una persona sacarse el carné de conducir?
// Pseudocódigo (en español, antes de programar):
//   SI tiene 18 años o más
//       SI ha aprobado el teórico → "Puede presentarse al práctico"
//       SI NO                     → "Tiene que aprobar el teórico"
//   SI NO → "Todavía no tiene edad"

$edad = 19;
$teoricoAprobado = false;

if ($edad >= 18) {
    if ($teoricoAprobado) {
        echo "Puede presentarse al práctico";
    } else {
        echo "Tiene que aprobar el teórico";
    }
} else {
    echo "Todavía no tiene edad";
}
