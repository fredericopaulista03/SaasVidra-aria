<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Orçamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tenant.budgets.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Cliente -->
                            <div>
                                <x-input-label for="client_id" :value="__('Selecione o Cliente')" />
                                <select id="client_id" name="client_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Selecione...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->city }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                                <p class="mt-2 text-sm text-gray-500">
                                    Não encontrou o cliente? <a href="{{ route('tenant.clients.create') }}" class="text-indigo-600 hover:text-indigo-900">Cadastrar novo cliente</a>.
                                </p>
                            </div>

                            <!-- Validade -->
                            <div>
                                <x-input-label for="valid_until" :value="__('Válido Até')" />
                                <x-text-input id="valid_until" class="block mt-1 w-full" type="date" name="valid_until" :value="now()->addDays(15)->format('Y-m-d')" />
                                <x-input-error :messages="$errors->get('valid_until')" class="mt-2" />
                            </div>

                            <!-- Notas Iniciais -->
                            <div>
                                <x-input-label for="notes" :value="__('Observações Iniciais')" />
                                <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tenant.budgets.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Iniciar Orçamento') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
