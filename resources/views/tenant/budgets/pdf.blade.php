<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento #{{ $budget->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            padding: 30px;
        }
        
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2563eb;
            font-size: 28pt;
            margin-bottom: 5px;
        }
        
        .header .company-name {
            font-size: 16pt;
            color: #1e40af;
            font-weight: bold;
        }
        
        .info-section {
            margin-bottom: 30px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .info-box h3 {
            color: #2563eb;
            font-size: 12pt;
            margin-bottom: 10px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
        }
        
        .info-box p {
            margin: 5px 0;
            font-size: 10pt;
        }
        
        .info-label {
            font-weight: bold;
            color: #64748b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table thead {
            background: #2563eb;
            color: white;
        }
        
        table thead th {
            padding: 12px 8px;
            text-align: left;
            font-size: 10pt;
            font-weight: 600;
        }
        
        table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10pt;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals {
            margin-top: 30px;
            float: right;
            width: 300px;
        }
        
        .totals table {
            margin: 0;
        }
        
        .totals td {
            padding: 8px;
            border: none;
        }
        
        .totals .total-row {
            background: #2563eb;
            color: white;
            font-weight: bold;
            font-size: 12pt;
        }
        
        .notes {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .notes h3 {
            color: #2563eb;
            margin-bottom: 10px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 9pt;
            color: #64748b;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-draft {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-sent {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">{{ config('app.name', 'VidroSmart') }}</div>
            <h1>ORÇAMENTO</h1>
            <p style="font-size: 10pt; color: #64748b;">
                Nº {{ str_pad($budget->id, 6, '0', STR_PAD_LEFT) }} | 
                Data: {{ $budget->created_at->format('d/m/Y') }} |
                <span class="status-badge status-{{ $budget->status }}">{{ ucfirst($budget->status) }}</span>
            </p>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <div class="info-col">
                <div class="info-box">
                    <h3>Cliente</h3>
                    <p><span class="info-label">Nome:</span> {{ $budget->client->name }}</p>
                    @if($budget->client->email)
                        <p><span class="info-label">Email:</span> {{ $budget->client->email }}</p>
                    @endif
                    @if($budget->client->phone)
                        <p><span class="info-label">Telefone:</span> {{ $budget->client->phone }}</p>
                    @endif
                    @if($budget->client->document)
                        <p><span class="info-label">CPF/CNPJ:</span> {{ $budget->client->document }}</p>
                    @endif
                    @if($budget->client->address)
                        <p><span class="info-label">Endereço:</span> 
                            {{ $budget->client->address }}
                            @if($budget->client->number), {{ $budget->client->number }}@endif
                            @if($budget->client->complement) - {{ $budget->client->complement }}@endif
                        </p>
                        <p>{{ $budget->client->neighborhood }} - {{ $budget->client->city }}/{{ $budget->client->state }}</p>
                        @if($budget->client->zip_code)
                            <p>CEP: {{ $budget->client->zip_code }}</p>
                        @endif
                    @endif
                </div>
            </div>
            
            <div class="info-col">
                <div class="info-box">
                    <h3>Informações do Orçamento</h3>
                    <p><span class="info-label">Número:</span> {{ str_pad($budget->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><span class="info-label">Data de Emissão:</span> {{ $budget->created_at->format('d/m/Y') }}</p>
                    @if($budget->valid_until)
                        <p><span class="info-label">Válido até:</span> {{ \Carbon\Carbon::parse($budget->valid_until)->format('d/m/Y') }}</p>
                    @endif
                    <p><span class="info-label">Status:</span> {{ ucfirst($budget->status) }}</p>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 40%;">Descrição</th>
                    <th style="width: 12%;" class="text-center">Largura</th>
                    <th style="width: 12%;" class="text-center">Altura</th>
                    <th style="width: 10%;" class="text-center">Qtd</th>
                    <th style="width: 13%;" class="text-right">Preço Unit.</th>
                    <th style="width: 13%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budget->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">
                        @if($item->width)
                            {{ number_format($item->width, 0) }}mm
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->height)
                            {{ number_format($item->height, 0) }}mm
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($item->quantity, 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td class="text-right">R$ {{ number_format($budget->subtotal, 2, ',', '.') }}</td>
                </tr>
                @if($budget->discount > 0)
                <tr>
                    <td><strong>Desconto:</strong></td>
                    <td class="text-right">- R$ {{ number_format($budget->discount, 2, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>TOTAL:</strong></td>
                    <td class="text-right"><strong>R$ {{ number_format($budget->total, 2, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Notes and Payment Terms -->
        @if($budget->payment_terms || $budget->notes)
        <div class="notes">
            @if($budget->payment_terms)
            <div style="margin-bottom: 20px;">
                <h3>Condições de Pagamento</h3>
                <p>{{ $budget->payment_terms }}</p>
            </div>
            @endif
            
            @if($budget->notes)
            <div>
                <h3>Observações</h3>
                <p>{{ $budget->notes }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name', 'VidroSmart') }}</strong></p>
            <p>Este orçamento foi gerado automaticamente em {{ now()->format('d/m/Y H:i') }}</p>
            <p>Orçamento válido por {{ $budget->valid_until ? \Carbon\Carbon::parse($budget->valid_until)->diffInDays(now()) : 15 }} dias</p>
        </div>
    </div>
</body>
</html>
