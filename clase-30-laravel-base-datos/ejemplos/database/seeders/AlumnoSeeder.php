<?php

namespace Database\Seeders;

use App\Models\Alumno;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        Alumno::factory(40)->create();

        $alumnos = DB::table('alumnos')->pluck('id');
        $cursos = DB::table('cursos')->pluck('id');

        // Cada alumno se matricula en entre 1 y 3 cursos distintos
        foreach ($alumnos as $alumnoId) {
            foreach ($cursos->random(rand(1, 3)) as $cursoId) {
                DB::table('alumno_curso')->insert([
                    'alumno_id' => $alumnoId,
                    'curso_id' => $cursoId,
                    'nota' => fake()->optional(0.6)->randomFloat(2, 3, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
