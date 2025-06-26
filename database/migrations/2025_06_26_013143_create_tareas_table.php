<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('materia_id', 26);
            $table->foreign('materia_id')
                  ->references('id')
                  ->on('materias')
                  ->onDelete('cascade');
            $table->string('documento')->nullable();
            $table->text('observaciones')->nullable();
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_cierre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
