<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Excepciones\EmailDuplicadoException;
use App\Excepciones\SinPlazasException;
use App\Modelos\Alumno;
use PDO;
use PDOException;

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

    // Ejercicios 06 y 08: crea el alumno y lo devuelve ya con su id
    public function crear(string $nombre, string $email, int $cursoId): Alumno
    {
        try {
            $consulta = $this->pdo->prepare("INSERT INTO alumnos (nombre, email, curso_id) VALUES (:nombre, :email, :curso)");
            $consulta->execute(["nombre" => $nombre, "email" => $email, "curso" => $cursoId]);
        } catch (PDOException $e) {
            // 1062: clave duplicada (la columna email es UNIQUE)
            if (($e->errorInfo[1] ?? 0) === 1062) {
                throw new EmailDuplicadoException($email);
            }
            throw $e;
        }

        return new Alumno((int) $this->pdo->lastInsertId(), $nombre, $email, $cursoId);
    }

    // Ejercicio 07: todo o nada, con una transacción
    public function cambiarDeCurso(int $alumnoId, int $cursoNuevoId): void
    {
        $this->pdo->beginTransaction();
        try {
            $consulta = $this->pdo->prepare("SELECT curso_id FROM alumnos WHERE id = :id FOR UPDATE");
            $consulta->execute(["id" => $alumnoId]);
            $cursoAntiguoId = (int) $consulta->fetchColumn();

            $consulta = $this->pdo->prepare("SELECT titulo, plazas FROM cursos WHERE id = :id FOR UPDATE");
            $consulta->execute(["id" => $cursoNuevoId]);
            $cursoNuevo = $consulta->fetch();
            if ($cursoNuevo["plazas"] < 1) {
                throw new SinPlazasException($cursoNuevo["titulo"]);
            }

            $this->pdo->prepare("UPDATE cursos SET plazas = plazas - 1 WHERE id = :id")->execute(["id" => $cursoNuevoId]);
            $this->pdo->prepare("UPDATE cursos SET plazas = plazas + 1 WHERE id = :id")->execute(["id" => $cursoAntiguoId]);
            $this->pdo->prepare("UPDATE alumnos SET curso_id = :curso WHERE id = :id")->execute(["curso" => $cursoNuevoId, "id" => $alumnoId]);

            $this->pdo->commit();
        } catch (\Throwable $error) {
            $this->pdo->rollBack();
            throw $error;
        }
    }
}
