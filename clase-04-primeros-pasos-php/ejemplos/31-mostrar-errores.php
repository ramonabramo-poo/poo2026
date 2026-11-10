<?php
// Ver todos los errores mientras desarrolláis
ini_set("display_errors", 1);
error_reporting(E_ALL);

echo "Los errores se mostrarán en pantalla.<br>";

// Provocamos un aviso a propósito:
echo $variableQueNoExiste;
