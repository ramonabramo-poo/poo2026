<?php
declare(strict_types=1);

$entrada = "PHP,  html , css,php , MySQL";

$etiquetas = explode(",", $entrada);
$etiquetas = array_map(fn($e) => mb_strtolower(trim($e)), $etiquetas);
$etiquetas = array_unique($etiquetas);
sort($etiquetas);

echo implode(" · ", $etiquetas);   // css · html · mysql · php
