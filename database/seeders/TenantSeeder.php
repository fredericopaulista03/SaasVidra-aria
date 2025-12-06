<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use App\Models\KanbanColumn;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Tenant
        $tenantId = 'vidracaria-demo';
        $tenant = Tenant::find($tenantId);
        if ($tenant) {
            $tenant->delete();
        }

        $tenant = Tenant::create(['id' => $tenantId]);
        $tenant->domains()->create(['domain' => 'demo.localhost']);

        // Initialize Tenancy (Important for Single DB scoping)
        tenancy()->initialize($tenant);

        // 2. Create Tenant Admin User
        $user = User::create([
            'name' => 'Admin Vidraçaria',
            'email' => 'admin@vidracaria.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
        ]);

        $user->assignRole('owner');

        // 3. Create Default Kanban Columns
        $columns = [
            ['name' => 'Medição', 'slug' => 'medicao', 'order_index' => 1, 'color' => 'bg-blue-100'],
            ['name' => 'Orçamento', 'slug' => 'orcamento', 'order_index' => 2, 'color' => 'bg-yellow-100'],
            ['name' => 'Aprovado', 'slug' => 'aprovado', 'order_index' => 3, 'color' => 'bg-green-100'],
            ['name' => 'Produção', 'slug' => 'producao', 'order_index' => 4, 'color' => 'bg-orange-100'],
            ['name' => 'Instalação', 'slug' => 'instalacao', 'order_index' => 5, 'color' => 'bg-purple-100'],
            ['name' => 'Finalizado', 'slug' => 'finalizado', 'order_index' => 6, 'color' => 'bg-gray-100'],
        ];

        foreach ($columns as $column) {
            KanbanColumn::create($column);
        }

        // End Tenancy
        tenancy()->end();
    }
}
