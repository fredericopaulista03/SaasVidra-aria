<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'manage budgets',
            'create measures',
            'create projects',
            'update kanban',
            'use chat',
            'manage finance',
            'manage users',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $roles = [
            'owner' => $permissions, // Owner has all permissions
            'admin' => $permissions, // Admin has all permissions
            'orçamentista' => ['manage budgets', 'create measures', 'create projects', 'use chat'],
            'instalador' => ['update kanban', 'use chat'],
            'atendimento' => ['manage budgets', 'use chat', 'update kanban'],
            'financeiro' => ['manage finance'],
            'viewer' => [], // Read-only access (handled by policies usually)
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePermissions);
        }
    }
}
