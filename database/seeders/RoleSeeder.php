<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'ver-usuarios',
            'crear-cursos',
            'editar-cursos',
            'eliminar-cursos',
            'ver-cursos',
            'inscribir-cursos'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'ver-usuarios',
            'crear-cursos',
            'editar-cursos',
            'eliminar-cursos',
            'ver-cursos',
        ]);

        $profesor = Role::create(['name' => 'profesor']);
        $profesor->givePermissionTo([
            'editar-cursos',
            'ver-cursos',
            'ver-usuarios',
        ]);

        $estudiante = Role::create(['name' => 'estudiante']);
        $estudiante->givePermissionTo([
            'ver-cursos',
            'ver-usuarios',
            'inscribir-cursos',
        ]);
    }
}