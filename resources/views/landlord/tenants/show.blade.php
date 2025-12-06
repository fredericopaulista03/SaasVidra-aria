<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalhes da Empresa: ') }} {{ $tenant->id }}
            </h2>
            <a href="{{ route('landlord.empresas.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Telefone do Proprietário</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tenant->formatted_phone }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">CPF/CNPJ</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tenant->formatted_document }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Site da Empresa</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($tenant->website)
                                    <a href="{{ $tenant->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $tenant->website }}</a>
                                @else
                                    <span class="text-gray-400">Não informado</span>
                                @endif
                            </p>
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
                    </div>
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
                            <form action="{{ route('landlord.empresas.suspend', $tenant) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Tem certeza que deseja suspender esta empresa?')">
                                    Suspender Empresa
                                </button>
                            </form>
                        @else
                            <form action="{{ route('landlord.empresas.activate', $tenant) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Ativar Empresa
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('landlord.empresas.destroy', $tenant) }}" method="POST">
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
