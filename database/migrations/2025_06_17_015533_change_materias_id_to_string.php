<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->string('id', 26)->change(); // Tamaño suficiente para ULID
        });
    }

    public function down()
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->id()->change(); // Revertir a auto-incremental
        });
    }
};