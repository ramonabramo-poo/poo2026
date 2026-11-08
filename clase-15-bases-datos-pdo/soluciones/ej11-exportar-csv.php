<?php
declare(strict_types=1);

require_once __DIR__ . "/../ejemplos/includes/conexion.php";
require_once __DIR__ . "/../ejemplos/includes/funciones.php";

$pdo = conectar();
$cursoId = (int) ($_GET["curso"] ?? 1);

$consulta = $pdo->prepare("SELECT nombre, email, nota FROM alumnos WHERE curso_id = :curso ORDER BY nombre");
$consulta->execute(["curso" => $cursoId]);
$alumnos = $consulta->fetchAll();

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=\"alumnos-curso-$cursoId.csv\"");

$salida = fopen("php://output", "w");
fwrite($salida, "\xEF\xBB\xBF");
fputcsv($salida, ["Nombre", "Email", "Nota"], ";", '"', "\\");
foreach ($alumnos as $alumno) {
    fputcsv($salida, [$alumno["nombre"], $alumno["email"], $alumno["nota"] ?? ""], ";", '"', "\\");
}
fclose($salida);
