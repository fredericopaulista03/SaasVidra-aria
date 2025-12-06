@extends('emails.layout')

@section('content')
    <h2 style="color: #667eea; margin-top: 0;">📄 Nova Fatura Gerada</h2>
    
    <p>Olá,</p>
    
    <p>Uma nova fatura foi gerada para sua conta.</p>

    <div class="info-box">
        <table>
            <tr>
                <th>Número da Fatura:</th>
                <td><strong>{{ $invoice->invoice_number }}</strong></td>
            </tr>
            <tr>
                <th>Valor:</th>
                <td><strong style="color: #667eea; font-size: 18px;">R$ {{ number_format($invoice->amount, 2, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <th>Vencimento:</th>
                <td>{{ $invoice->due_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>
                    <span style="background-color: #ffc107; color: #000; padding: 4px 8px; border-radius: 3px; font-size: 12px;">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    @if($invoice->subscription)
        <p>Esta fatura refere-se à sua assinatura do plano <strong>{{ $invoice->subscription->plan->name }}</strong>.</p>
    @endif

    @if($invoice->notes)
        <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0;">
            <strong>Observações:</strong><br>
            {{ $invoice->notes }}
        </div>
    @endif

    <p style="margin-top: 30px;">
        <a href="{{ url('/dashboard') }}" class="button">Ver Fatura</a>
    </p>

    <p style="color: #6c757d; font-size: 14px; margin-top: 30px;">
        Por favor, efetue o pagamento até a data de vencimento para evitar a suspensão dos serviços.
    </p>
@endsection
