<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Painel Administrativo SaaS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de Tenants</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['total_tenants'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Assinaturas Ativas</div>
                        <div class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active_subscriptions'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Em Teste</div>
                        <div class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['trial_subscriptions'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Total</div>
                        <div class="text-3xl font-bold text-blue-600 mt-2">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('admin.plans.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2">Planos</h3>
                    <p class="text-sm opacity-90">Gerenciar planos de assinatura</p>
                </a>

                <a href="{{ route('admin.subscriptions.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2">Assinaturas</h3>
                    <p class="text-sm opacity-90">Ver todas as assinaturas</p>
                </a>

                <a href="{{ route('admin.invoices.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2">Faturas</h3>
                    <p class="text-sm opacity-90">{{ $stats['pending_invoices'] }} pendentes</p>
                </a>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Subscriptions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Assinaturas Recentes</h3>
                        <div class="space-y-3">
                            @forelse($stats['recent_subscriptions'] as $sub)
                                <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $sub->tenant->id }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $sub->plan->name }}</div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $sub->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($sub->status) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma assinatura ainda</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Invoices -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Faturas Recentes</h3>
                        <div class="space-y-3">
                            @forelse($stats['recent_invoices'] as $invoice)
                                <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $invoice->invoice_number }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->tenant->id }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">R$ {{ number_format($invoice->amount, 2, ',', '.') }}</div>
                                        <span class="text-xs {{ $invoice->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma fatura ainda</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
