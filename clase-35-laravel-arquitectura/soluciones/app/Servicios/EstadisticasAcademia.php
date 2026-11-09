<?php

namespace App\Servicios;

use App\Models\Alumno;
use App\Models\Curso;

// Ejercicio 04: las cifras de la academia, en un único sitio
class EstadisticasAcademia
{
    public function totalCursos(): int
    {
        return Curso::count();
    }

    public function totalAlumnos(): int
    {
        return Alumno::count();
    }

    public function totalMatriculas(): int
    {
        return Curso::withCount('alumnos')->get()->sum('alumnos_count');
    }

    public function precioMedio(): float
    {
        return round((float) Curso::avg('precio'), 2);
    }

    // El curso con más alumnos (o null si no hay cursos)
    public function cursoMasPopular(): ?Curso
    {
        return Curso::withCount('alumnos')->orderByDesc('alumnos_count')->first();
    }
}
