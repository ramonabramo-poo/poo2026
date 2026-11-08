<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Modelos\Curso;

// Un repositorio que guarda los cursos en un array, sin base de datos.
// Muy útil para hacer pruebas rápidas sin tocar los datos reales.
class CursoRepositorioMemoria implements CursoRepositorioInterface
{
    private array $cursos = [];
    private int $siguienteId = 1;

    public function contar(string $busqueda = ""): int
    {
        return count($this->filtrar($busqueda));
    }

    public function buscar(string $busqueda, int $pagina, int $porPagina): array
    {
        $cursos = $this->filtrar($busqueda);
        usort($cursos, fn(Curso $a, Curso $b) => strcmp($a->titulo, $b->titulo));
        return array_slice($cursos, ($pagina - 1) * $porPagina, $porPagina);
    }

    public function buscarPorId(int $id): ?Curso
    {
        return $this->cursos[$id] ?? null;
    }

    public function guardar(Curso $curso): void
    {
        if ($curso->id === null) {
            $curso->id = $this->siguienteId++;
        }
        $this->cursos[$curso->id] = $curso;
    }

    public function borrar(int $id): bool
    {
        if (!isset($this->cursos[$id])) {
            return false;
        }
        unset($this->cursos[$id]);
        return true;
    }

    private function filtrar(string $busqueda): array
    {
        return array_values(array_filter(
            $this->cursos,
            fn(Curso $curso) => $busqueda === "" || mb_stripos($curso->titulo, $busqueda) !== false
        ));
    }
}
