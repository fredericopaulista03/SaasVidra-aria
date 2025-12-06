<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Básico',
                'slug' => 'basico',
                'description' => 'Plano ideal para vidraçarias pequenas que estão começando',
                'price' => 49.90,
                'billing_cycle' => 'monthly',
                'features' => [
                    'Até 50 clientes',
                    'Até 20 orçamentos/mês',
                    'Gestão de produtos',
                    'Controle financeiro básico',
                    'Suporte por email',
                ],
                'max_users' => 2,
                'max_clients' => 50,
                'max_budgets' => 20,
                'is_active' => true,
                'trial_days' => 7,
                'sort_order' => 1,
            ],
            [
                'name' => 'Profissional',
                'slug' => 'profissional',
                'description' => 'Para vidraçarias em crescimento que precisam de mais recursos',
                'price' => 99.90,
                'billing_cycle' => 'monthly',
                'features' => [
                    'Até 200 clientes',
                    'Orçamentos ilimitados',
                    'Gestão completa de produtos',
                    'Controle financeiro avançado',
                    'Kanban de produção',
                    'Agenda de instalações',
                    'WhatsApp integrado',
                    'Suporte prioritário',
                ],
                'max_users' => 5,
                'max_clients' => 200,
                'max_budgets' => null,
                'is_active' => true,
                'trial_days' => 14,
                'sort_order' => 2,
            ],
            [
                'name' => 'Empresarial',
                'slug' => 'empresarial',
                'description' => 'Solução completa para grandes vidraçarias',
                'price' => 199.90,
                'billing_cycle' => 'monthly',
                'features' => [
                    'Clientes ilimitados',
                    'Orçamentos ilimitados',
                    'Gestão completa de produtos',
                    'Controle financeiro avançado',
                    'Kanban de produção',
                    'Agenda de instalações',
                    'WhatsApp integrado',
                    'Portal do cliente',
                    'Relatórios avançados',
                    'API de integração',
                    'Suporte prioritário 24/7',
                    'Treinamento personalizado',
                ],
                'max_users' => null,
                'max_clients' => null,
                'max_budgets' => null,
                'is_active' => true,
                'trial_days' => 30,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::create($planData);
        }
    }
}
