<?php
declare(strict_types=1);

$alumnos = [
    ["nombre" => "Marta", "email" => "marta@example.com", "nota" => 8.5],
    ["nombre" => "Luis", "email" => "luis@example.com", "nota" => 6],
    ["nombre" => "Ana", "email" => "ana@example.com", "nota" => 9.25],
];

// Estas cabeceras le dicen al navegador que es un archivo para descargar
header("Content-Type: text/csv; charset=utf-8");
header('Content-Disposition: attachment; filename="alumnos.csv"');

// php://output es "la respuesta": escribimos el CSV directamente al navegador
$salida = fopen("php://output", "w");
fwrite($salida, "\xEF\xBB\xBF");   // marca para que Excel reconozca las tildes
fputcsv($salida, ["Nombre", "Email", "Nota"], ";", '"', "\\");
foreach ($alumnos as $alumno) {
    fputcsv($salida, [$alumno["nombre"], $alumno["email"], str_replace(".", ",", (string) $alumno["nota"])], ";", '"', "\\");
}
fclose($salida);
