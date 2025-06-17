<?php

namespace Database\Seeders;

use App\Models\Materia;
use App\Models\Departamento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener un departamento existente o crear uno por defecto
        $departamento = Departamento::firstOrCreate([
            'name' => 'Ciencias Básicas',
        ]);

        $materias = [
            [
                'nombre' => 'Matemáticas I',
                'descripcion' => 'Álgebra básica y cálculo diferencial',
                'departamento_id' => $departamento->id,
                'slug' => Str::slug('Matemáticas I') // Generar slug aquí
            ],
            [
                'nombre' => 'Física General',
                'descripcion' => 'Fundamentos de mecánica clásica',
                'departamento_id' => $departamento->id,
                'slug' => Str::slug('Física General')
            ],
            [
                'nombre' => 'Programación Básica',
                'descripcion' => 'Introducción a la programación con Python',
                'departamento_id' => $departamento->id,
                'slug' => Str::slug('Programación Básica')
            ],
            [
                'nombre' => 'Base de Datos',
                'descripcion' => 'Fundamentos de diseño y consultas SQL',
                'departamento_id' => $departamento->id,
                'slug' => Str::slug('Base de Datos')
            ]
        ];

        foreach ($materias as $materiaData) {
            Materia::firstOrCreate(
                ['nombre' => $materiaData['nombre']],
                $materiaData
            );
        }

        $this->command->info('4 materias creadas con sus slugs correspondientes!');
    }
}