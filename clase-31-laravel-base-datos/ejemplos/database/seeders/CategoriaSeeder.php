<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Programación', 'slug' => 'programacion', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Diseño', 'slug' => 'diseno', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ofimática', 'slug' => 'ofimatica', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
