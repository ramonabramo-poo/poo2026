<?php
declare(strict_types=1);

function doble(int $n): int
{
    return $n * 2;
}

// Mientras desarrolláis, queréis VER todos los errores
ini_set("display_errors", "1");
error_reporting(E_ALL);

$alumno = ["nombre" => "Ana"];

echo "<h2>Los tipos de error más habituales</h2>";

// 1. WARNING: algo va mal, pero PHP sigue
echo $alumno["email"] ?? "(sin email)";   // con ?? no hay aviso
echo "<br>";
// echo $alumno["email"];   ← Warning: Undefined array key "email"

// 2. ERROR FATAL: PHP se para en seco
// echo funcionQueNoExiste();   ← Fatal error: Call to undefined function

// 3. PARSE ERROR (error de sintaxis): PHP ni siquiera empieza
// echo "falta el punto y coma"   ← Parse error: syntax error, unexpected...

// 4. TYPE ERROR: un tipo que no encaja (con strict_types)
echo doble(4) . "<br>";
// echo doble("4");   ← TypeError: Argument #1 ($n) must be of type int, string given

echo "Fin del script";
