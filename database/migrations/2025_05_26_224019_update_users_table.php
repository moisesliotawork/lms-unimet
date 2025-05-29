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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn("name","first_name");
            $table->string("username")->unique()->after("id");
            $table->string("second_name")->nullable()->after("first_name");
            $table->string("last_name")->after("second_name");
            $table->string("second_last_name")->nullable()->after("last_name");
            $table->string("phone")->unique()->after("email");
            $table->text("address")->nullable()->after("phone");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn("first_name","name");
            $table->dropColumn(["username","second_name","last_name","second_last_name","phone","address"]);
            
        });
    }
};
