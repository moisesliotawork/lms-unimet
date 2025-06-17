<?php

namespace Database\Seeders;

use App\Models\Materia;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfesorMateriaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el usuario profesor
        $profesor = User::where('email', 'profesor@example.com')->first();

        if (!$profesor) {
            $this->command->error('No se encontró el usuario profesor con email profesor@example.com');
            return;
        }

        // Obtener 3 materias aleatorias
        $materias = Materia::inRandomOrder()->limit(3)->get();

        if ($materias->isEmpty()) {
            $this->command->error('No hay materias disponibles para asignar');
            return;
        }

        // Asignar materias al profesor
        foreach ($materias as $materia) {
            $profesor->materiasComoProfesor()->syncWithoutDetaching([
                $materia->id => [
                    'role' => 'profesor',
                ]
            ]);
        }

        $this->command->info("Se asignaron {$materias->count()} materias al profesor {$profesor->name}");
    }
}