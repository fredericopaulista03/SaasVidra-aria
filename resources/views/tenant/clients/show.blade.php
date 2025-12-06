<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalhes do Cliente') }}: {{ $client->name }}
            </h2>
            <div>
                <a href="{{ route('tenant.clients.edit', $client) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('tenant.clients.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informações de Contato</h3>
                            <dl class="mt-2 text-sm text-gray-600">
                                <div class="mt-1">
                                    <dt class="font-medium text-gray-900">Email:</dt>
                                    <dd>{{ $client->email ?? 'N/A' }}</dd>
                                </div>
                                <div class="mt-1">
                                    <dt class="font-medium text-gray-900">Telefone:</dt>
                                    <dd>{{ $client->phone ?? 'N/A' }}</dd>
                                </div>
                                <div class="mt-1">
                                    <dt class="font-medium text-gray-900">CPF/CNPJ:</dt>
                                    <dd>{{ $client->document ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Endereço</h3>
                            <dl class="mt-2 text-sm text-gray-600">
                                <div class="mt-1">
                                    <dd>
                                        {{ $client->address }}, {{ $client->number }}
                                        @if($client->complement) - {{ $client->complement }} @endif
                                        <br>
                                        {{ $client->neighborhood }}
                                        <br>
                                        {{ $client->city }} - {{ $client->state }}
                                        <br>
                                        CEP: {{ $client->zip_code }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    @if($client->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Observações</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $client->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
