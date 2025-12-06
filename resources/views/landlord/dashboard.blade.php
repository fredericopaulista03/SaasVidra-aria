<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do Administrador (Landlord)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Tenants -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total de Vidraçarias</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_tenants'] }}</div>
                </div>

                <!-- Active Subscriptions (Mock) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Assinaturas Ativas</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">{{ $stats['total_tenants'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">100% adimplentes</div>
                </div>

                <!-- Monthly Revenue (Mock) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Receita Mensal (Est.)</div>
                    <div class="mt-2 text-3xl font-bold text-blue-600">R$ {{ number_format($stats['total_tenants'] * 97, 2, ',', '.') }}</div>
                </div>
            </div>

            <!-- Recent Tenants -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Vidraçarias Recentes</h3>
                        <a href="{{ route('landlord.tenants.index') }}" class="text-sm text-blue-600 hover:text-blue-900">Ver todas</a>
                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domínio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($stats['recent_tenants'] as $tenant)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $tenant->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach($tenant->domains as $domain)
                                            <a href="http://{{ $domain->domain }}" target="_blank" class="text-blue-600 hover:underline">{{ $domain->domain }}</a>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
