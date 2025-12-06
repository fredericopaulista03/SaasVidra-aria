<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orçamento #{{ $budget->id }} - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-2xl mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Orçamento #{{ $budget->id }}</h1>
                <p class="text-gray-500">Emitido em {{ $budget->created_at->format('d/m/Y') }}</p>
                <div class="mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $budget->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $budget->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $budget->status === 'draft' || $budget->status === 'sent' ? 'bg-blue-100 text-blue-800' : '' }}">
                        {{ ucfirst($budget->status) }}
                    </span>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Client Info -->
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Cliente</h2>
                <p class="text-gray-900">{{ $budget->client->name }}</p>
                <p class="text-gray-600">{{ $budget->client->email }}</p>
            </div>

            <!-- Items -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Itens</h2>
                <div class="space-y-4">
                    @foreach($budget->items as $item)
                        <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $item->quantity }}x 
                                    @if($item->width && $item->height)
                                        ({{ number_format($item->width/1000, 2) }}m x {{ number_format($item->height/1000, 2) }}m)
                                    @endif
                                </p>
                            </div>
                            <div class="font-semibold text-gray-900">
                                R$ {{ number_format($item->total, 2, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals -->
            <div class="border-t border-gray-200 pt-6 mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">R$ {{ number_format($budget->subtotal, 2, ',', '.') }}</span>
                </div>
                @if($budget->discount > 0)
                    <div class="flex justify-between items-center mb-2 text-green-600">
                        <span>Desconto</span>
                        <span>- R$ {{ number_format($budget->discount, 2, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center mt-4 text-xl font-bold text-gray-900">
                    <span>Total</span>
                    <span>R$ {{ number_format($budget->total, 2, ',', '.') }}</span>
                </div>
            </div>

            <!-- Actions -->
            @if($budget->status === 'draft' || $budget->status === 'sent')
                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                    <a href="{{ URL::signedRoute('tenant.portal.approve', $budget) }}" 
                       class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center font-bold py-3 px-6 rounded-lg transition transform hover:scale-105 shadow-md">
                        Aprovar Orçamento
                    </a>
                    <a href="{{ URL::signedRoute('tenant.portal.reject', $budget) }}" 
                       class="flex-1 bg-red-100 hover:bg-red-200 text-red-700 text-center font-bold py-3 px-6 rounded-lg transition">
                        Rejeitar
                    </a>
                </div>
                <p class="text-center text-xs text-gray-400 mt-4">Ao aprovar, você concorda com os termos de serviço.</p>
            @else
                <div class="text-center p-4 bg-gray-50 rounded-lg text-gray-500">
                    Este orçamento já foi {{ $budget->status === 'approved' ? 'aprovado' : 'rejeitado' }}.
                </div>
            @endif

        </div>
        
        <div class="mt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>
</body>
</html>
