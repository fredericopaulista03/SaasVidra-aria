<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Plano') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('landlord.plans.update', $plan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug *</label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $plan->slug) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço (R$) *</label>
                                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $plan->price) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="billing_cycle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciclo *</label>
                                <select name="billing_cycle" id="billing_cycle" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                                    <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) === 'monthly' ? 'selected' : '' }}>Mensal</option>
                                    <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) === 'yearly' ? 'selected' : '' }}>Anual</option>
                                </select>
                            </div>

                            <div>
                                <label for="trial_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dias de Teste *</label>
                                <input type="number" name="trial_days" id="trial_days" value="{{ old('trial_days', $plan->trial_days) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="max_users" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Máx. Usuários</label>
                                <input type="number" name="max_users" id="max_users" value="{{ old('max_users', $plan->max_users) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="max_clients" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Máx. Clientes</label>
                                <input type="number" name="max_clients" id="max_clients" value="{{ old('max_clients', $plan->max_clients) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="max_budgets" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Máx. Orçamentos</label>
                                <input type="number" name="max_budgets" id="max_budgets" value="{{ old('max_budgets', $plan->max_budgets) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">{{ old('description', $plan->description) }}</textarea>
                        </div>

                        <div class="mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Plano Ativo</span>
                            </label>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('landlord.plans.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancelar</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
