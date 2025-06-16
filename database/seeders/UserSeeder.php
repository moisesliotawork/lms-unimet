<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario admin
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'first_name' => 'Admin',
            'last_name' => 'Sistema',
            'phone' => '1234567890',
            'address' => 'Dirección del administrador',
        ]);
        $admin->assignRole('admin');

        // Crear usuario profesor
        $profesor = User::create([
            'username' => 'profesor',
            'email' => 'profesor@example.com',
            'password' => Hash::make('123456'),
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'phone' => '0987654321',
            'address' => 'Dirección del profesor',
        ]);
        $profesor->assignRole('profesor');

        // Crear usuario estudiante
        $estudiante = User::create([
            'username' => 'estudiante',
            'email' => 'estudiante@example.com',
            'password' => Hash::make('123456'),
            'first_name' => 'María',
            'last_name' => 'Gómez',
            'phone' => '5555555555',
            'address' => 'Dirección del estudiante',
        ]);
        $estudiante->assignRole('estudiante');

        // Crear usuarios de prueba (10) y asignarles roles aleatorios
        $users = User::factory()->count(10)->create();
        $roles = Role::all();

        foreach ($users as $user) {
            // Asignar rol aleatorio (80% estudiante, 15% profesor, 5% admin)
            $random = rand(1, 100);
            
            if ($random <= 5) {
                $user->assignRole('admin');
            } elseif ($random <= 20) {
                $user->assignRole('profesor');
            } else {
                $user->assignRole('estudiante');
            }
        }
    }
}