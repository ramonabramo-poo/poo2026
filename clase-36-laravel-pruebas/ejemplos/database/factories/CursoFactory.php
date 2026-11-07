<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CursoFactory extends Factory
{
    public function definition(): array
    {
        // Faker no inventa textos en español, así que combinamos temas y niveles sin repetir
        $temas = ['Python', 'SQL', 'Photoshop', 'WordPress', 'Inglés', 'Marketing digital', 'React', 'Git', 'Linux', 'Docker'];
        $niveles = ['básico', 'intermedio', 'avanzado', 'práctico'];
        [$tema, $nivel] = fake()->unique()->randomElement(Arr::crossJoin($temas, $niveles));
        $titulo = "$tema $nivel";

        return [
            // Si no le decimos la categoría, crea una nueva
            'categoria_id' => Categoria::factory(),
            // El slug lo genera el mutator del modelo a partir del título (clase 31)
            'titulo' => $titulo,
            'descripcion' => "Aprende $tema con un enfoque $nivel, con ejercicios y un proyecto final.",
            'horas' => fake()->randomElement([20, 25, 30, 40, 50, 60, 80]),
            'precio' => fake()->numberBetween(9, 45) * 10,
            'plazas' => fake()->numberBetween(10, 25),
            'fecha_inicio' => fake()->dateTimeBetween('now', '+6 months'),
            'publicado' => fake()->boolean(85),
        ];
    }

    // Un "estado": php artisan tinker → Curso::factory()->sinPublicar()->create()
    public function sinPublicar(): static
    {
        return $this->state(fn () => ['publicado' => false]);
    }
}
