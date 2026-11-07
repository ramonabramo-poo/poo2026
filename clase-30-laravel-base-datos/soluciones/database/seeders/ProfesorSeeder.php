<?php

namespace Database\Seeders;

use App\Models\Profesor;
use Illuminate\Database\Seeder;

class ProfesorSeeder extends Seeder
{
    public function run(): void
    {
        Profesor::factory()->create([
            'nombre' => 'Ramón',
            'apellidos' => 'Abramo',
            'email' => 'ramon@academia-alpe.test',
            'especialidad' => 'Programación',
            'anios_experiencia' => 25,
        ]);

        Profesor::factory(5)->create();
    }
}
