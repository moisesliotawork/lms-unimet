<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('profesor_materia', function (Blueprint $table) {
            $table->string('role')->default('profesor')->after('materia_id');
        });
    }

    public function down()
    {
        Schema::table('profesor_materia', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};