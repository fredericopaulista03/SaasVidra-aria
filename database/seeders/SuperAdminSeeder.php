<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the Super Admin role exists
        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // Create the Super Admin user
        $user = User::firstOrCreate(
            ['email' => 'fredericopaulista@gmail.com'],
            [
                'name' => 'Frederico Paulista',
                'password' => Hash::make('Davi2014!'),
                'tenant_id' => null, // Super Admin does not belong to any tenant
            ]
        );

        $user->assignRole($role);
    }
}
