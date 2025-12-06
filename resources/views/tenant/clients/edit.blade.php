<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Cliente') }}: {{ $client->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tenant.clients.update', $client) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nome -->
                            <div>
                                <x-input-label for="name" :value="__('Nome Completo')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $client->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $client->email)" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Telefone -->
                            <div>
                                <x-input-label for="phone" :value="__('Telefone / WhatsApp')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $client->phone)" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- CPF/CNPJ -->
                            <div>
                                <x-input-label for="document" :value="__('CPF / CNPJ')" />
                                <x-text-input id="document" class="block mt-1 w-full" type="text" name="document" :value="old('document', $client->document)" />
                                <x-input-error :messages="$errors->get('document')" class="mt-2" />
                            </div>

                            <!-- CEP -->
                            <div>
                                <x-input-label for="zip_code" :value="__('CEP')" />
                                <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code', $client->zip_code)" />
                                <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                            </div>

                            <!-- Endereço -->
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Endereço')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $client->address)" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <!-- Número -->
                            <div>
                                <x-input-label for="number" :value="__('Número')" />
                                <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number', $client->number)" />
                                <x-input-error :messages="$errors->get('number')" class="mt-2" />
                            </div>

                            <!-- Complemento -->
                            <div>
                                <x-input-label for="complement" :value="__('Complemento')" />
                                <x-text-input id="complement" class="block mt-1 w-full" type="text" name="complement" :value="old('complement', $client->complement)" />
                                <x-input-error :messages="$errors->get('complement')" class="mt-2" />
                            </div>

                            <!-- Bairro -->
                            <div>
                                <x-input-label for="neighborhood" :value="__('Bairro')" />
                                <x-text-input id="neighborhood" class="block mt-1 w-full" type="text" name="neighborhood" :value="old('neighborhood', $client->neighborhood)" />
                                <x-input-error :messages="$errors->get('neighborhood')" class="mt-2" />
                            </div>

                            <!-- Cidade -->
                            <div>
                                <x-input-label for="city" :value="__('Cidade')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $client->city)" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <!-- Estado -->
                            <div>
                                <x-input-label for="state" :value="__('Estado (UF)')" />
                                <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state', $client->state)" maxlength="2" />
                                <x-input-error :messages="$errors->get('state')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="mt-6">
                            <x-input-label for="notes" :value="__('Observações')" />
                            <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('notes', $client->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tenant.clients.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Atualizar Cliente') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
