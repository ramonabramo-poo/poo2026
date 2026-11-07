<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained()->restrictOnDelete();
            $table->string('titulo', 120);
            $table->string('slug', 140)->unique();
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('horas');
            $table->decimal('precio', 8, 2);
            $table->unsignedSmallInteger('plazas')->default(20);
            $table->date('fecha_inicio')->nullable();
            $table->boolean('publicado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
