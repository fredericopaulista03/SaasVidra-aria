@extends('emails.layout')

@section('content')
    <h2 style="color: #28a745; margin-top: 0;">✅ Pagamento Confirmado!</h2>
    
    <p>Olá,</p>
    
    <p>Confirmamos o recebimento do pagamento da fatura <strong>{{ $invoice->invoice_number }}</strong>.</p>

    <div class="info-box">
        <table>
            <tr>
                <th>Fatura:</th>
                <td>{{ $invoice->invoice_number }}</td>
            </tr>
            <tr>
                <th>Valor:</th>
                <td><strong>R$ {{ number_format($invoice->amount, 2, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <th>Data de Pagamento:</th>
                <td>{{ $invoice->paid_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Método:</th>
                <td>{{ ucfirst($invoice->payment_method ?? 'N/A') }}</td>
            </tr>
        </table>
    </div>

    @if($invoice->subscription)
        <p>Sua assinatura do plano <strong>{{ $invoice->subscription->plan->name }}</strong> está ativa e renovada.</p>
    @endif

    <p>Obrigado por utilizar nossos serviços!</p>

    <p style="margin-top: 30px;">
        <a href="{{ url('/dashboard') }}" class="button">Acessar Painel</a>
    </p>

    <p style="color: #6c757d; font-size: 14px; margin-top: 30px;">
        Se você tiver alguma dúvida, entre em contato conosco.
    </p>
@endsection
