<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Vidraçaria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('landlord.empresas.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div>
                                <x-input-label for="company_name" :value="__('Nome da Empresa')" />
                                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus placeholder="ex: Vidraçaria Centro" />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <!-- Owner Phone -->
                            <div>
                                <x-input-label for="owner_phone" :value="__('Telefone do Proprietário')" />
                                <x-text-input id="owner_phone" class="block mt-1 w-full" type="text" name="owner_phone" :value="old('owner_phone')" required placeholder="(00) 00000-0000" />
                                <x-input-error :messages="$errors->get('owner_phone')" class="mt-2" />
                            </div>

                            <!-- Document (CPF/CNPJ) -->
                            <div>
                                <x-input-label for="document" :value="__('CPF ou CNPJ')" />
                                <x-text-input id="document" class="block mt-1 w-full" type="text" name="document" :value="old('document')" required placeholder="000.000.000-00 ou 00.000.000/0000-00" />
                                <x-input-error :messages="$errors->get('document')" class="mt-2" />
                            </div>

                            <!-- Website -->
                            <div>
                                <x-input-label for="website" :value="__('Site da Empresa (Opcional)')" />
                                <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" placeholder="https://exemplo.com.br" />
                                <x-input-error :messages="$errors->get('website')" class="mt-2" />
                            </div>

                            <!-- Owner Name -->
                            <div>
                                <x-input-label for="name" :value="__('Nome do Proprietário')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Owner Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email do Proprietário')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Senha de Acesso')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('landlord.empresas.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Criar Vidraçaria') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
