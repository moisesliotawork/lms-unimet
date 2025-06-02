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

        // Crear permisos (opcional, si los necesitas)
        Permission::create(['name' => 'crear-usuarios']);
        Permission::create(['name' => 'editar-cursos']);
        Permission::create(['name' => 'inscribir-cursos']);

        // Crear roles y asignar permisos
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'ver-usuarios',
            'editar-cursos',
            'crear-cursos',
            'ver-cursos',
            'eliminar-cursos',
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
        ]);
    }
}