<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configurações do Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf

                <!-- Navigation Tabs -->
                <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8">
                        <a href="{{ route('admin.settings.index') }}" 
                           class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                            Configurações Gerais
                        </a>
                        <a href="{{ route('admin.email-templates.index') }}" 
                           class="border-transparent hover:border-gray-300 py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400">
                            Templates de Email
                        </a>
                    </nav>
                </div>

                <!-- Payment Settings -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Configurações de Pagamento (Asaas)</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="asaas_api_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">API Key</label>
                                <input type="password" name="asaas_api_key" id="asaas_api_key" 
                                    value="{{ old('asaas_api_key', $paymentSettings['asaas_api_key'] ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="Deixe em branco para manter o valor atual">
                                <p class="mt-1 text-sm text-gray-500">Obtenha sua API Key no painel do Asaas</p>
                                @error('asaas_api_key')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="asaas_environment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ambiente *</label>
                                <select name="asaas_environment" id="asaas_environment" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                                    <option value="sandbox" {{ old('asaas_environment', $paymentSettings['asaas_environment'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox (Teste)</option>
                                    <option value="production" {{ old('asaas_environment', $paymentSettings['asaas_environment'] ?? '') === 'production' ? 'selected' : '' }}>Produção</option>
                                </select>
                            </div>

                            <div>
                                <label for="asaas_webhook_token" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Webhook Token</label>
                                <input type="password" name="asaas_webhook_token" id="asaas_webhook_token"
                                    value="{{ old('asaas_webhook_token', $paymentSettings['asaas_webhook_token'] ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="Deixe em branco para manter o valor atual">
                                <p class="mt-1 text-sm text-gray-500">Token para validar webhooks do Asaas</p>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                <strong>URL do Webhook:</strong> {{ url('/webhooks/asaas') }}
                            </p>
                            <p class="text-sm text-blue-600 dark:text-blue-300 mt-1">
                                Configure esta URL no painel do Asaas para receber notificações de pagamento.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Configurações de Email (SMTP)</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="mail_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Servidor SMTP</label>
                                <input type="text" name="mail_host" id="mail_host"
                                    value="{{ old('mail_host', $emailSettings['mail_host'] ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="smtp.gmail.com">
                            </div>

                            <div>
                                <label for="mail_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Porta</label>
                                <input type="number" name="mail_port" id="mail_port"
                                    value="{{ old('mail_port', $emailSettings['mail_port'] ?? '587') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="587">
                            </div>

                            <div>
                                <label for="mail_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Usuário</label>
                                <input type="text" name="mail_username" id="mail_username"
                                    value="{{ old('mail_username', $emailSettings['mail_username'] ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="seu-email@gmail.com">
                            </div>

                            <div>
                                <label for="mail_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                                <input type="password" name="mail_password" id="mail_password"
                                    value="{{ old('mail_password', $emailSettings['mail_password'] ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="Deixe em branco para manter">
                            </div>

                            <div>
                                <label for="mail_encryption" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Criptografia</label>
                                <select name="mail_encryption" id="mail_encryption"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                                    <option value="tls" {{ old('mail_encryption', $emailSettings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ old('mail_encryption', $emailSettings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>

                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Remetente</label>
                                <input type="email" name="mail_from_address" id="mail_from_address"
                                    value="{{ old('mail_from_address', $emailSettings['mail_from_address'] ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="noreply@vidracariabh.com.br">
                            </div>

                            <div class="md:col-span-2">
                                <label for="mail_from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome Remetente</label>
                                <input type="text" name="mail_from_name" id="mail_from_name"
                                    value="{{ old('mail_from_name', $emailSettings['mail_from_name'] ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                                    placeholder="CRM Vidraçaria">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Salvar Configurações
                    </button>
                </div>
            </form>

            <!-- Test Email Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Testar Configuração de Email</h3>
                    <form action="{{ route('admin.settings.test-email') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="email" name="test_email" required
                            class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm"
                            placeholder="email@exemplo.com">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Enviar Email de Teste
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
