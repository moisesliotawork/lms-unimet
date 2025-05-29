<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'), // Cambia esto en producción
            'first_name' => 'Admin',
            'last_name' => 'Sistema',
            'phone' => '1234567890',
            'address' => 'Dirección del administrador',
        ]);

        // Crear usuarios de prueba
        User::factory()->count(10)->create();
    }
}
