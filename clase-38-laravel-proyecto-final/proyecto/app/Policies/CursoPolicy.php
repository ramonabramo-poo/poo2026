<?php

namespace App\Policies;

use App\Models\Curso;
use App\Models\User;

// Quién puede hacer qué con los cursos. Laravel la encuentra sola por el nombre: Curso → CursoPolicy
class CursoPolicy
{
    // Se ejecuta antes que todo lo demás: el administrador puede con todo
    public function before(User $user, string $accion): ?bool
    {
        return $user->esAdmin() ? true : null;
    }

    public function create(User $user): bool
    {
        return $user->esEditor();
    }

    public function update(User $user, Curso $curso): bool
    {
        return $user->esEditor();
    }

    // Borrar, solo el administrador (ya respondió true en before())
    public function delete(User $user, Curso $curso): bool
    {
        return false;
    }
}
