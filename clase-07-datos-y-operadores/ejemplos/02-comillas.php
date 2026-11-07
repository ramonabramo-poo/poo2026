<?php
$alumna = "Laura";
$modulo = "PHP 8";

// 1. Comillas simples: texto literal, PHP no mira dentro
echo 'Bienvenida $alumna al curso de $modulo';
// Bienvenida $alumna al curso de $modulo
echo "<br>";

// 2. Comillas dobles: PHP sustituye las variables
echo "Bienvenida $alumna al curso de $modulo";
// Bienvenida Laura al curso de PHP 8
echo "<br>";

// 3. Comillas dobles con llaves: la forma más clara y la que os recomiendo
echo "Bienvenida {$alumna} al curso de {$modulo}";
echo "<br>";

// Las llaves son imprescindibles cuando la variable va pegada a otro texto
$cantidad = 3;
$unidad = "kilo";
echo "Compra {$cantidad} {$unidad}s de naranjas";   // 3 kilos
echo "<br>";

// 4. Concatenación con el punto
echo "Bienvenida " . $alumna . " al aula.";
echo "<br>";

// 5. ¿Y si necesito comillas dentro del texto?
echo "Ella dijo: 'hola'";           // simples dentro de dobles: sin problema
echo "<br>";
echo "Ella dijo: \"hola\"";         // dobles dentro de dobles: con barra invertida
