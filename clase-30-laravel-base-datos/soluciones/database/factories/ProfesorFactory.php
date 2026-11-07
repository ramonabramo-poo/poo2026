<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellidos' => fake()->lastName() . ' ' . fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'especialidad' => fake()->randomElement(['Programación', 'Diseño', 'Ofimática', 'Bases de datos', 'Sistemas']),
            'anios_experiencia' => fake()->numberBetween(1, 30),
        ];
    }
}
