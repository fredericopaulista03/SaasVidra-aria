<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Lançamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tenant.finance.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Description -->
                            <div class="col-span-2">
                                <x-input-label for="description" :value="__('Descrição')" />
                                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description', $transaction->description)" required autofocus />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Tipo')" />
                                <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Receita (Entrada)</option>
                                    <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Despesa (Saída)</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Amount -->
                            <div>
                                <x-input-label for="amount" :value="__('Valor (R$)')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" :value="old('amount', $transaction->amount)" required />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Due Date -->
                            <div>
                                <x-input-label for="due_date" :value="__('Data de Vencimento')" />
                                <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date" :value="old('due_date', $transaction->due_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>

                            <!-- Paid At -->
                            <div>
                                <x-input-label for="paid_at" :value="__('Data de Pagamento (Opcional)')" />
                                <x-text-input id="paid_at" class="block mt-1 w-full" type="date" name="paid_at" :value="old('paid_at', $transaction->paid_at ? $transaction->paid_at->format('Y-m-d') : '')" />
                                <p class="text-xs text-gray-500 mt-1">Preencha apenas se já foi pago/recebido.</p>
                                <x-input-error :messages="$errors->get('paid_at')" class="mt-2" />
                            </div>

                            <!-- Client -->
                            <div class="col-span-2">
                                <x-input-label for="client_id" :value="__('Cliente (Opcional)')" />
                                <select id="client_id" name="client_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Selecione um cliente...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id', $transaction->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tenant.finance.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Salvar Alterações') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
