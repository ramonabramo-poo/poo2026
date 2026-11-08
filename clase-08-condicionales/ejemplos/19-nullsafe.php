<?php
// ?-> (nullsafe, PHP 8): si lo de la izquierda es null, no sigue y devuelve null
// Los objetos los veremos en la clase 17; aquí basta con saber que $fecha puede ser un objeto o null
$fechaTexto = "";   // probad también con "2026-12-25"

$fecha = $fechaTexto !== "" ? new DateTime($fechaTexto) : null;

// Sin ?-> tendríamos que preguntar antes si $fecha es null
$bonita = $fecha?->format("d/m/Y") ?? "sin fecha";

echo "Fecha: $bonita";
