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
        $ramon = User::factory()->create([
            'name' => 'Ramón Abramo',
            'email' => 'ramon@academia-alpe.test',
        ]);

        // Relación uno a uno: crea el perfil ya unido al usuario
        $ramon->perfil()->create([
            'ciudad' => 'Santander',
            'biografia' => 'Profesor de programación en Alpe Formación.',
        ]);

        // El orden importa: los cursos necesitan categorías, y las matrículas, cursos
        $this->call([
            CategoriaSeeder::class,
            CursoSeeder::class,
            AlumnoSeeder::class,
        ]);
    }
}
