<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla intermedia (pivote): un alumno en muchos cursos y un curso con muchos alumnos
        Schema::create('alumno_curso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
            $table->decimal('nota', 4, 2)->nullable();
            $table->timestamps();

            $table->unique(['alumno_id', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumno_curso');
    }
};
