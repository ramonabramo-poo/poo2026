<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Excepciones\CursoConAlumnosException;
use App\Modelos\Curso;
use PDO;
use PDOException;

// El REPOSITORIO: el único sitio que sabe hablar SQL con la tabla cursos.
// Recibe y devuelve objetos Curso, nunca arrays sueltos.
class CursoRepositorio
{
    public function __construct(private PDO $pdo)
    {
    }

    public function contar(string $busqueda = ""): int
    {
        $consulta = $this->pdo->prepare("SELECT COUNT(*) FROM cursos WHERE titulo LIKE :busqueda");
        $consulta->execute(["busqueda" => "%{$busqueda}%"]);
        return (int) $consulta->fetchColumn();
    }

    /** @return Curso[] */
    public function buscar(string $busqueda, int $pagina, int $porPagina): array
    {
        $consulta = $this->pdo->prepare(
            "SELECT id, titulo, horas, precio, plazas
             FROM cursos
             WHERE titulo LIKE :busqueda
             ORDER BY titulo
             LIMIT :limite OFFSET :desde"
        );
        $consulta->bindValue("busqueda", "%{$busqueda}%", PDO::PARAM_STR);
        $consulta->bindValue("limite", $porPagina, PDO::PARAM_INT);
        $consulta->bindValue("desde", ($pagina - 1) * $porPagina, PDO::PARAM_INT);
        $consulta->execute();

        return array_map(fn(array $fila) => Curso::desdeFila($fila), $consulta->fetchAll());
    }

    public function buscarPorId(int $id): ?Curso
    {
        $consulta = $this->pdo->prepare("SELECT id, titulo, horas, precio, plazas FROM cursos WHERE id = :id");
        $consulta->execute(["id" => $id]);
        $fila = $consulta->fetch();
        return $fila === false ? null : Curso::desdeFila($fila);
    }

    // Si el curso no tiene id, es nuevo (INSERT); si lo tiene, ya existe (UPDATE)
    public function guardar(Curso $curso): void
    {
        $datos = [
            "titulo" => $curso->titulo,
            "horas" => $curso->horas,
            "precio" => $curso->precio,
            "plazas" => $curso->plazas,
        ];

        if ($curso->id === null) {
            $consulta = $this->pdo->prepare(
                "INSERT INTO cursos (titulo, horas, precio, plazas) VALUES (:titulo, :horas, :precio, :plazas)"
            );
            $consulta->execute($datos);
            $curso->id = (int) $this->pdo->lastInsertId();
        } else {
            $consulta = $this->pdo->prepare(
                "UPDATE cursos SET titulo = :titulo, horas = :horas, precio = :precio, plazas = :plazas WHERE id = :id"
            );
            $consulta->execute($datos + ["id" => $curso->id]);
        }
    }

    public function borrar(int $id): bool
    {
        try {
            $consulta = $this->pdo->prepare("DELETE FROM cursos WHERE id = :id");
            $consulta->execute(["id" => $id]);
            return $consulta->rowCount() === 1;
        } catch (PDOException $e) {
            // 1451: la clave foránea no deja borrar un curso que tiene alumnos
            if (($e->errorInfo[1] ?? 0) === 1451) {
                throw new CursoConAlumnosException($id);
            }
            throw $e;
        }
    }
}
