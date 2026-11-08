<?php
$celsius = 23.5;

$fahrenheit = $celsius * 9 / 5 + 32;
$kelvin = $celsius + 273.15;

echo "$celsius ºC son " . number_format($fahrenheit, 1, ",", ".") . " ºF";
echo " y " . number_format($kelvin, 2, ",", ".") . " K";
