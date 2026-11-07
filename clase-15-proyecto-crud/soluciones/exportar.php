<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

$nombreArchivo = "cursos-" . date("Y-m-d") . ".csv";

requerirLogin();
$pdo = conectar();

$cursos = $pdo->query("SELECT titulo, horas, precio, plazas FROM cursos ORDER BY titulo")->fetchAll();

// Cabeceras: le decimos al navegador que esto es un archivo para descargar, no una página
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=\"{$nombreArchivo}\"");

$salida = fopen("php://output", "w");
fwrite($salida, "\xEF\xBB\xBF");   // marca BOM: así Excel muestra bien las tildes
fputcsv($salida, ["Título", "Horas", "Precio", "Plazas"], ";", '"', "\\");
foreach ($cursos as $curso) {
    fputcsv($salida, $curso, ";", '"', "\\");
}
fclose($salida);
