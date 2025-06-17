<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Verificar si existe la tabla original antes de renombrar
        if (Schema::hasTable('users_materia')) {
            Schema::rename('users_materia', 'materia_user');
        }

        // Si la tabla ya fue renombrada a users_materia en una migración anterior
        if (Schema::hasTable('users_materia')) {
            Schema::rename('users_materia', 'materia_user');
        }
    }

    public function down()
    {
        // Revertir el cambio en caso de rollback
        if (Schema::hasTable('materia_user')) {
            Schema::rename('materia_user', 'users_materia');
        }
    }
};