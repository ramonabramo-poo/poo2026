<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Ejercicio 04: quién creó cada curso
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            // nullable: los cursos que ya existían no tienen autor.
            // Si se borra el usuario, sus cursos se quedan sin autor (no se borran)
            $table->foreignId('user_id')->nullable()->after('categoria_id')
                ->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
