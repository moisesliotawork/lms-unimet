<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('123456'), // Todos los usuarios de prueba tendrán esta contraseña
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'second_name' => $this->faker->firstName,
            'second_last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];
    }
}