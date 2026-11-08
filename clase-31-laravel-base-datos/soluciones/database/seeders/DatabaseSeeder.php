<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ramón Abramo',
            'email' => 'ramon@academia-alpe.test',
        ]);

        // El orden importa: los cursos necesitan categorías, y las matrículas, cursos
        $this->call([
            CategoriaSeeder::class,
            CursoSeeder::class,
            AlumnoSeeder::class,
            ProfesorSeeder::class,  // Ejercicio 01
            ValoracionSeeder::class,  // Ejercicio 05
        ]);
    }
}
