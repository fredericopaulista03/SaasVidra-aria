<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orçamento #{{ $budget->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 print:p-0 print:bg-white">

    <div class="max-w-4xl mx-auto bg-white p-8 shadow-md print:shadow-none">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8 border-b pb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Vidraçaria Demo</h1>
                <p class="text-gray-600">Rua Exemplo, 123 - Centro</p>
                <p class="text-gray-600">Tel: (11) 99999-9999</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-800">Orçamento #{{ $budget->id }}</h2>
                <p class="text-gray-600">Data: {{ $budget->created_at->format('d/m/Y') }}</p>
                <p class="text-gray-600">Validade: {{ $budget->valid_until ? $budget->valid_until->format('d/m/Y') : '15 dias' }}</p>
            </div>
        </div>

        <!-- Client Info -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-800 border-b mb-2">Dados do Cliente</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p><span class="font-semibold">Nome:</span> {{ $budget->client->name }}</p>
                    <p><span class="font-semibold">Telefone:</span> {{ $budget->client->phone }}</p>
                    <p><span class="font-semibold">Email:</span> {{ $budget->client->email }}</p>
                </div>
                <div>
                    <p><span class="font-semibold">Endereço:</span> {{ $budget->client->address }}, {{ $budget->client->number }}</p>
                    <p>{{ $budget->client->neighborhood }} - {{ $budget->client->city }}/{{ $budget->client->state }}</p>
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-800 border-b mb-2">Itens</h3>
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2">Descrição</th>
                        <th class="p-2 text-center">Medidas (mm)</th>
                        <th class="p-2 text-center">Qtd</th>
                        <th class="p-2 text-right">Unit.</th>
                        <th class="p-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($budget->items as $item)
                        <tr class="border-b">
                            <td class="p-2">
                                {{ $item->description }}
                                @if($item->product->type === 'glass')
                                    <br><span class="text-xs text-gray-500">{{ $item->product->color }} {{ $item->product->thickness }}mm</span>
                                @endif
                            </td>
                            <td class="p-2 text-center">
                                @if($item->width && $item->height)
                                    {{ number_format($item->width, 0) }} x {{ number_format($item->height, 0) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-2 text-center">{{ number_format($item->quantity, 2) }}</td>
                            <td class="p-2 text-right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td class="p-2 text-right">R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="flex justify-end mb-8">
            <div class="w-1/3">
                <div class="flex justify-between py-1">
                    <span class="font-semibold">Subtotal:</span>
                    <span>R$ {{ number_format($budget->subtotal, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="font-semibold">Desconto:</span>
                    <span>R$ {{ number_format($budget->discount, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-t border-gray-800 mt-2">
                    <span class="font-bold text-xl">Total:</span>
                    <span class="font-bold text-xl">R$ {{ number_format($budget->total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($budget->notes || $budget->payment_terms)
            <div class="mb-8 grid grid-cols-2 gap-8">
                @if($budget->payment_terms)
                    <div>
                        <h4 class="font-bold text-gray-800 mb-1">Condições de Pagamento</h4>
                        <p class="text-sm text-gray-600">{{ $budget->payment_terms }}</p>
                    </div>
                @endif
                @if($budget->notes)
                    <div>
                        <h4 class="font-bold text-gray-800 mb-1">Observações</h4>
                        <p class="text-sm text-gray-600">{{ $budget->notes }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Footer -->
        <div class="text-center text-xs text-gray-500 mt-12 pt-4 border-t">
            <p>Gerado por Sistema Vidraçaria - {{ now()->format('d/m/Y H:i') }}</p>
            <div class="mt-8 flex justify-center space-x-4 no-print">
                <a href="{{ route('tenant.budgets.edit', $budget) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Imprimir
                </button>
                
                <!-- Client Link -->
                <div x-data="{ copied: false }">
                    <button @click="navigator.clipboard.writeText('{{ URL::signedRoute('tenant.portal.budget', $budget) }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        <span x-show="!copied">Copiar Link</span>
                        <span x-show="copied">Copiado!</span>
                    </button>
                </div>

                <!-- WhatsApp Share -->
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $budget->client->phone ?? '') }}?text={{ urlencode('Olá ' . $budget->client->name . ', segue o link do seu orçamento: ' . URL::signedRoute('tenant.portal.budget', $budget)) }}" 
                   target="_blank"
                   class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    WhatsApp
                </a>

                <a href="{{ route('tenant.budgets.index') }}" class="text-gray-600 hover:text-gray-900 font-bold py-2 px-4 rounded">
                    Voltar
                </a>
            </div>
        </div>
    </div>

</body>
</html>
