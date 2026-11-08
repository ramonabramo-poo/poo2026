<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Modelos\Alumno;
use PDO;

class AlumnoRepositorio
{
    public function __construct(private PDO $pdo)
    {
    }

    /** @return Alumno[] */
    public function todosConCurso(): array
    {
        $filas = $this->pdo->query(
            "SELECT a.id, a.nombre, a.email, a.curso_id, c.titulo AS titulo_curso
             FROM alumnos a
             INNER JOIN cursos c ON a.curso_id = c.id
             ORDER BY a.nombre"
        )->fetchAll();
        return array_map(fn(array $fila) => Alumno::desdeFila($fila), $filas);
    }

    /** @return Alumno[] */
    public function delCurso(int $cursoId): array
    {
        $consulta = $this->pdo->prepare(
            "SELECT id, nombre, email, curso_id FROM alumnos WHERE curso_id = :curso ORDER BY nombre"
        );
        $consulta->execute(["curso" => $cursoId]);
        return array_map(fn(array $fila) => Alumno::desdeFila($fila), $consulta->fetchAll());
    }
}
