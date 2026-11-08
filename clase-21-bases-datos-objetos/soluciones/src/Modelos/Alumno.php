<?php
declare(strict_types=1);

namespace App\Modelos;

class Alumno
{
    public function __construct(
        public readonly int $id,
        public readonly string $nombre,
        public readonly string $email,
        public readonly int $cursoId,
        public readonly ?string $tituloCurso = null,   // solo si la consulta trae el JOIN
    ) {
    }

    public static function desdeFila(array $fila): Alumno
    {
        return new Alumno(
            (int) $fila["id"],
            $fila["nombre"],
            $fila["email"],
            (int) $fila["curso_id"],
            $fila["titulo_curso"] ?? null,
        );
    }
}
