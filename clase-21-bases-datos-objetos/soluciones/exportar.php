<?php
declare(strict_types=1);

// Ejercicio 10: el CSV del catálogo, reutilizando el repositorio
require_once __DIR__ . "/includes/inicio.php";

use App\BaseDatos\Conexion;
use App\Repositorios\CursoRepositorio;

$cursosRepo = new CursoRepositorio(Conexion::obtener());
$cursos = $cursosRepo->buscar("", 1, $cursosRepo->contar());

header("Content-Type: text/csv; charset=utf-8");
header('Content-Disposition: attachment; filename="catalogo.csv"');

$salida = fopen("php://output", "w");
fwrite($salida, "\xEF\xBB\xBF");
fputcsv($salida, ["Título", "Horas", "Precio", "Precio con IVA", "Estado"], ";", '"', "\\");
foreach ($cursos as $curso) {
    fputcsv($salida, [
        $curso->titulo,
        $curso->horas,
        number_format($curso->precio, 2, ",", ""),
        number_format($curso->precioConIva(), 2, ",", ""),
        $curso->estaCompleto() ? "Completo" : "Con plazas",
    ], ";", '"', "\\");
}
fclose($salida);
