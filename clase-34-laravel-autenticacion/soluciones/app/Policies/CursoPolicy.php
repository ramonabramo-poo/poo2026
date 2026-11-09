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

    // Ejercicio 08: ?User porque también la consultan los invitados (sin sesión).
    // OJO: con un invitado, before() no se ejecuta (no hay $user), pero view() sí
    public function view(?User $user, Curso $curso): bool
    {
        if ($curso->publicado) {
            return true;
        }

        // Un curso sin publicar solo lo ven los editores (y el admin, por before())
        return $user?->esEditor() ?? false;
    }

    public function create(User $user): bool
    {
        return $user->esEditor();
    }

    // Ejercicio 04: un editor solo puede editar SUS cursos
    public function update(User $user, Curso $curso): bool
    {
        return $user->esEditor() && $curso->user_id === $user->id;
    }

    // Borrar, solo el administrador (ya respondió true en before())
    public function delete(User $user, Curso $curso): bool
    {
        return false;
    }
}
