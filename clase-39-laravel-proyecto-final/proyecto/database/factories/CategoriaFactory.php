<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoriaFactory extends Factory
{
    public function definition(): array
    {
        $nombre = fake()->unique()->randomElement(['Idiomas', 'Marketing', 'Fotografía', 'Redes', 'Contabilidad']);

        return [
            'nombre' => $nombre,
            'slug' => Str::slug($nombre),
        ];
    }
}
