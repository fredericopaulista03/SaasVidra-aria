<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalhes da Empresa: ') }} {{ $tenant->id }}
            </h2>
            <a href="{{ route('landlord.tenants.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informações Básicas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informações Básicas</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nome da Empresa</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tenant->company_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID da Empresa</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tenant->id }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $tenant->status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $tenant->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($tenant->status ?? 'active') }}
                                </span>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Criado em</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tenant->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Atualizado em</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tenant->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Domínios -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Domínios</h3>
                    
                    @if($tenant->domains->count() > 0)
                        <ul class="space-y-2">
                            @foreach($tenant->domains as $domain)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <a href="http://{{ $domain->domain }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ $domain->domain }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum domínio configurado.</p>
                    @endif
                </div>
            </div>

            <!-- Assinaturas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Assinaturas</h3>
                    
                    @if($tenant->subscriptions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Plano</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Início</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Término</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($tenant->subscriptions as $subscription)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $subscription->plan->name }}
                                            </td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $subscription->status === 'trial' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $subscription->status === 'canceled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($subscription->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $subscription->starts_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $subscription->ends_at ? $subscription->ends_at->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma assinatura encontrada.</p>
                    @endif
                </div>
            </div>

            <!-- Ações -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ações</h3>
                    
                    <div class="flex space-x-3">
                        @if($tenant->status === 'active')
                            <form action="{{ route('landlord.tenants.suspend', $tenant) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Tem certeza que deseja suspender esta empresa?')">
                                    Suspender Empresa
                                </button>
                            </form>
                        @else
                            <form action="{{ route('landlord.tenants.activate', $tenant) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Ativar Empresa
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('landlord.tenants.destroy', $tenant) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('ATENÇÃO: Isso excluirá TODOS os dados desta empresa. Esta ação não pode ser desfeita! Continuar?')">
                                Excluir Empresa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
