<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Produto') }}: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tenant.products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nome -->
                            <div class="md:col-span-2">
                                <x-input-label for="name" :value="__('Nome do Produto')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Tipo -->
                            <div>
                                <x-input-label for="type" :value="__('Tipo')" />
                                <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="glass" {{ old('type', $product->type) == 'glass' ? 'selected' : '' }}>Vidro (m²)</option>
                                    <option value="hardware" {{ old('type', $product->type) == 'hardware' ? 'selected' : '' }}>Ferragem (un)</option>
                                    <option value="accessory" {{ old('type', $product->type) == 'accessory' ? 'selected' : '' }}>Acessório (un)</option>
                                    <option value="service" {{ old('type', $product->type) == 'service' ? 'selected' : '' }}>Serviço (un)</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Unidade -->
                            <div>
                                <x-input-label for="unit" :value="__('Unidade de Medida')" />
                                <x-text-input id="unit" class="block mt-1 w-full" type="text" name="unit" :value="old('unit', $product->unit)" required />
                                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                            </div>

                            <!-- Preço Venda -->
                            <div>
                                <x-input-label for="price" :value="__('Preço de Venda (R$)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', $product->price)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Preço Custo -->
                            <div>
                                <x-input-label for="cost_price" :value="__('Preço de Custo (R$)')" />
                                <x-text-input id="cost_price" class="block mt-1 w-full" type="number" step="0.01" name="cost_price" :value="old('cost_price', $product->cost_price)" />
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>

                            <!-- Espessura (Vidros) -->
                            <div>
                                <x-input-label for="thickness" :value="__('Espessura (mm) - Apenas Vidros')" />
                                <x-text-input id="thickness" class="block mt-1 w-full" type="number" step="0.1" name="thickness" :value="old('thickness', $product->thickness)" />
                                <x-input-error :messages="$errors->get('thickness')" class="mt-2" />
                            </div>

                            <!-- Cor -->
                            <div>
                                <x-input-label for="color" :value="__('Cor / Acabamento')" />
                                <x-text-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color', $product->color)" />
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('Descrição Detalhada')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tenant.products.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Atualizar Produto') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
