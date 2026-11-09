<?php

namespace Database\Seeders;

use App\Enums\Rol;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Tres usuarios, uno por rol. La contraseña de todos es "password"
        $ramon = User::factory()->create([
            'name' => 'Ramón Abramo',
            'email' => 'ramon@academia-alpe.test',
            'rol' => Rol::Admin,
        ]);

        $marta = User::factory()->create([
            'name' => 'Marta Editora',
            'email' => 'marta@academia-alpe.test',
            'rol' => Rol::Editor,
        ]);

        User::factory()->create([
            'name' => 'Pablo Usuario',
            'email' => 'pablo@academia-alpe.test',
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

        // Ejercicio 04: Marta es la autora de los tres primeros cursos; el resto, de Ramón
        Curso::query()->update(['user_id' => $ramon->id]);
        Curso::whereIn('id', [1, 2, 3])->update(['user_id' => $marta->id]);
    }
}
