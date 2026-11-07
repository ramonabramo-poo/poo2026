<?php
// 1. Conversión automática: PHP intenta "entender" lo que le damos
$a = "5" + 3;          // el texto "5" se convierte en número
var_dump($a);          // int(8)
echo "<br>";

$b = "5" . 3;          // el punto une textos: el 3 se convierte en "3"
var_dump($b);          // string(2) "53"
echo "<br>";

// 2. Conversión forzada: le decimos nosotros a qué tipo convertir
$precioTexto = "19.99";
$precio = (float) $precioTexto;
var_dump($precio);     // float(19.99)
echo "<br>";

$entero = (int) 7.9;   // ¡corta los decimales, no redondea!
var_dump($entero);     // int(7)
echo "<br>";

$texto = (string) 42;
var_dump($texto);      // string(2) "42"
echo "<br>";

// 3. ¿Qué se considera falso? Solo estos valores:
var_dump((bool) 0);       // false
var_dump((bool) "");      // false
var_dump((bool) "0");     // false (¡ojo con este!)
var_dump((bool) null);    // false
var_dump((bool) []);      // false
echo "<br>";
// Todo lo demás es verdadero, incluso "hola", -1 o "false"
var_dump((bool) "false"); // true
