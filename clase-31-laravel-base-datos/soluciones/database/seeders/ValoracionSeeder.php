<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Ejercicio 05: entre 0 y 4 valoraciones por curso
class ValoracionSeeder extends Seeder
{
    public function run(): void
    {
        $comentarios = ['Muy práctico', 'El profe explica genial', 'Se me hizo corto', null, 'Volvería a apuntarme'];

        foreach (DB::table('cursos')->pluck('id') as $cursoId) {
            for ($i = 0; $i < rand(0, 4); $i++) {
                DB::table('valoraciones')->insert([
                    'curso_id' => $cursoId,
                    'puntuacion' => rand(3, 5),
                    'comentario' => $comentarios[array_rand($comentarios)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
