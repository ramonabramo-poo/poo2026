<?php
// const: se escribe directamente en el código, fuera de cualquier if, bucle o función
const IVA = 0.21;
const NOMBRE_WEB = "Mi tienda";
const PRECIO_ENVIO = 4.95;
const TOTAL_MINIMO = PRECIO_ENVIO * 10;   // puede usar otras constantes

// define(): es una función, así que se ejecuta como cualquier otra instrucción
define("VERSION", "1.0");

// ...y por eso puede ir dentro de un if (const aquí daría un error de sintaxis)
$hora = (int) date("G");
if ($hora < 14) {
    define("SALUDO", "Buenos días");
} else {
    define("SALUDO", "Buenas tardes");
}

// define() también admite un valor calculado con funciones
define("ANIO_ACTUAL", (int) date("Y"));

// ...y un nombre construido con una variable
$idioma = "ES";
define("MONEDA_" . $idioma, "€");

echo SALUDO . " y bienvenidos a " . NOMBRE_WEB . " (versión " . VERSION . ")<br>";
echo "Pedido mínimo sin gastos de envío: " . TOTAL_MINIMO . " " . MONEDA_ES . "<br>";
echo "© " . ANIO_ACTUAL . "<br>";

// defined() pregunta si una constante existe
if (defined("IVA")) {
    echo "El IVA es del " . IVA * 100 . " %<br>";
}

// Una constante no se puede cambiar: si quitáis el comentario, PHP da un error
// IVA = 0.10;
