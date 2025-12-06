<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'payment-confirmed',
                'subject' => 'Pagamento Confirmado - {{invoice_number}}',
                'content' => '<h2 style="color: #28a745;">✅ Pagamento Confirmado!</h2>
<p>Olá,</p>
<p>Confirmamos o recebimento do pagamento da fatura <strong>{{invoice_number}}</strong>.</p>
<div style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0;">
    <p><strong>Fatura:</strong> {{invoice_number}}</p>
    <p><strong>Valor:</strong> R$ {{amount}}</p>
    <p><strong>Data de Pagamento:</strong> {{paid_at}}</p>
</div>
<p>Obrigado por utilizar nossos serviços!</p>',
                'variables' => json_encode(['invoice_number', 'amount', 'paid_at', 'plan_name']),
            ],
            [
                'name' => 'invoice-created',
                'subject' => 'Nova Fatura - {{invoice_number}}',
                'content' => '<h2 style="color: #667eea;">📄 Nova Fatura Gerada</h2>
<p>Olá,</p>
<p>Uma nova fatura foi gerada para sua conta.</p>
<div style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0;">
    <p><strong>Número da Fatura:</strong> {{invoice_number}}</p>
    <p><strong>Valor:</strong> R$ {{amount}}</p>
    <p><strong>Vencimento:</strong> {{due_date}}</p>
    <p><strong>Status:</strong> {{status}}</p>
</div>
<p>Por favor, efetue o pagamento até a data de vencimento para evitar a suspensão dos serviços.</p>',
                'variables' => json_encode(['invoice_number', 'amount', 'due_date', 'status', 'plan_name']),
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['name' => $template['name']],
                $template
            );
        }
    }
}
