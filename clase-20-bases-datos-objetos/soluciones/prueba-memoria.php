<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/inicio.php";

use App\Modelos\Curso;
use App\Repositorios\CursoRepositorioInterface;
use App\Repositorios\CursoRepositorioMemoria;

// Esta función no sabe si los cursos están en MySQL o en un array: solo conoce el contrato
function resumen(CursoRepositorioInterface $repositorio): string
{
    $nombres = array_map(fn(Curso $curso) => $curso->titulo, $repositorio->buscar("", 1, 10));
    return $repositorio->contar() . " cursos: " . implode(", ", $nombres);
}

$repositorio = new CursoRepositorioMemoria();
$repositorio->guardar(new Curso(null, "PHP 8 desde cero", 80, 250, 5));
$repositorio->guardar(new Curso(null, "Git y GitHub", 20, 60, 15));
$repositorio->guardar(new Curso(null, "Docker", 25, 95, 9));

echo resumen($repositorio) . "<br>";
$repositorio->borrar(2);
echo resumen($repositorio) . "<br>";
echo "Buscar «php»: " . $repositorio->contar("php") . " curso(s)";
