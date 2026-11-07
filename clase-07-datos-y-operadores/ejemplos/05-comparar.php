<?php
// == compara solo el valor (convirtiendo tipos si hace falta)
// === compara el valor Y el tipo
var_dump(5 == "5");       // true
var_dump(5 === "5");      // false: int frente a string
echo "<br>";

var_dump(0 == "");        // false en PHP 8
var_dump(null == false);  // true: los dos "valen" falso
var_dump(null === false); // false: tipos distintos
echo "<br>";

// Un caso real: un formulario siempre envía TEXTO
$edadDelFormulario = "18";

if ($edadDelFormulario === 18) {
    echo "No llegaremos aquí: \"18\" no es 18<br>";
}

// Lo correcto: convertir primero y comparar después
$edad = (int) $edadDelFormulario;
if ($edad === 18) {
    echo "Ahora sí: tiene 18 años<br>";
}

// Comparar textos
var_dump("hola" === "Hola");   // false: distingue mayúsculas
