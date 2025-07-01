<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material', function (Blueprint $table) {
            $table->id();
            $table->string('materia_id', 26);
            $table->foreign('materia_id')
                ->references('id')
                ->on('materias')
                ->onDelete('cascade');
            $table->string('titulo');
            $table->string('documento')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Agregar índice para mejorar rendimiento en búsquedas
            $table->index('materia_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};