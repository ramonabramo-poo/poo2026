<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Modelos\Curso;

// El contrato de cualquier almacén de cursos, sea MySQL, un array o un fichero
interface CursoRepositorioInterface
{
    public function contar(string $busqueda = ""): int;

    /** @return Curso[] */
    public function buscar(string $busqueda, int $pagina, int $porPagina): array;

    public function buscarPorId(int $id): ?Curso;

    public function guardar(Curso $curso): void;

    public function borrar(int $id): bool;
}
