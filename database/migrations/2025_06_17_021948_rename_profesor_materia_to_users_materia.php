<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Verificar si existe la tabla original antes de renombrar
        if (Schema::hasTable('profesor_materia')) {
            Schema::rename('profesor_materia', 'users_materia');
        }
    }

    public function down()
    {
        // Revertir el cambio en caso de rollback
        if (Schema::hasTable('users_materia')) {
            Schema::rename('users_materia', 'profesor_materia');
        }
    }
};