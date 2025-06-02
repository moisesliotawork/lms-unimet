<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username'          => 'testuser',
            'first_name'        => 'Test',
            'second_name'       => '',
            'last_name'         => 'User',
            'second_last_name'  => '',
            'email'             => 'test@example.com',
            'phone'             => '123456789',
            'address'           => 'Dirección de prueba',
            'email_verified_at' => now(),
            'password'          => bcrypt('password'), // o usa Hash::make('password')
            'remember_token'    => \Str::random(10),
        ]);
    }
}
