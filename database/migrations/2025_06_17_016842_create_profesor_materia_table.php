<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profesor_materia', function (Blueprint $table) {
            $table->id();

            // Relación con usuarios (profesores)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Relación con materias (usando string para ULID)
            $table->string('materia_id'); // Tipo string para ULID

            // Definir la clave foránea manualmente
            $table->foreign('materia_id')
                ->references('id')
                ->on('materias')
                ->cascadeOnDelete();

            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['user_id', 'materia_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('profesor_materia');
    }
};