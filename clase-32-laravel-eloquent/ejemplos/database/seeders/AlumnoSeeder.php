<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = Curso::pluck('id');

        // Cada alumno se matricula en entre 1 y 3 cursos distintos
        Alumno::factory(40)->create()->each(function (Alumno $alumno) use ($cursos) {
            foreach ($cursos->random(rand(1, 3)) as $cursoId) {
                $alumno->cursos()->attach($cursoId, [
                    'nota' => fake()->optional(0.6)->randomFloat(2, 3, 10),
                ]);
            }
        });
    }
}
