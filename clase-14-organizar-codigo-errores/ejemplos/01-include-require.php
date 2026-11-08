<?php
declare(strict_types=1);

// include: si el archivo no existe, avisa (Warning) y SIGUE
include __DIR__ . "/no-existe.php";
echo "Con include, el programa ha seguido adelante<br>";

// require: si el archivo no existe, error FATAL y se PARA
// Quitad las // de la línea siguiente y veréis que ya no se muestra nada más:
// require __DIR__ . "/no-existe.php";

// require_once: lo carga solo UNA vez, aunque lo pidáis varias
require_once __DIR__ . "/web/includes/funciones.php";
require_once __DIR__ . "/web/includes/funciones.php";   // no hace nada: ya estaba
echo e("<b>Con require_once no hay error de función repetida</b>") . "<br>";

// Si hubiéramos usado require dos veces, PHP diría:
// Fatal error: Cannot redeclare function e()

echo "Esta carpeta es: " . __DIR__;
