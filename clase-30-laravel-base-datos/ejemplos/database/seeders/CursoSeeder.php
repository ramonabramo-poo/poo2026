<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Los ids de las categorías, por su slug: ['programacion' => 1, ...]
        $categorias = DB::table('categorias')->pluck('id', 'slug');

        $cursos = [
            ['PHP desde cero', 'programacion', 60, 250],
            ['JavaScript moderno', 'programacion', 50, 220],
            ['Laravel profesional', 'programacion', 80, 390],
            ['Diseño web con Figma', 'diseno', 30, 180],
            ['Excel avanzado', 'ofimatica', 25, 120],
        ];

        foreach ($cursos as [$titulo, $categoria, $horas, $precio]) {
            Curso::factory()->create([
                'categoria_id' => $categorias[$categoria],
                'titulo' => $titulo,
                'slug' => Str::slug($titulo),
                'descripcion' => "Un curso de $horas horas para aprender $titulo paso a paso.",
                'horas' => $horas,
                'precio' => $precio,
                'publicado' => true,
            ]);
        }

        // Y diez cursos más, inventados, repartidos entre las categorías existentes
        Curso::factory(10)->create([
            'categoria_id' => fn () => $categorias->random(),
        ]);
    }
}
