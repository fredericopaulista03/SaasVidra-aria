<x-tenant-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel da Vidraçaria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Visão Geral - {{ now()->locale('pt_BR')->monthName }}</h3>
                        <span class="text-sm text-gray-500">Empresa: {{ auth()->user()->tenant_id }}</span>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-100">
                            <h4 class="text-sm font-semibold text-green-600 uppercase">Receitas (Mês)</h4>
                            <p class="text-2xl font-bold text-green-800 mt-2">R$ {{ number_format($revenue, 2, ',', '.') }}</p>
                        </div>
                        <div class="bg-red-50 p-6 rounded-lg shadow-sm border border-red-100">
                            <h4 class="text-sm font-semibold text-red-600 uppercase">Despesas (Mês)</h4>
                            <p class="text-2xl font-bold text-red-800 mt-2">R$ {{ number_format($expense, 2, ',', '.') }}</p>
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg shadow-sm border border-blue-100">
                            <h4 class="text-sm font-semibold text-blue-600 uppercase">Total Clientes</h4>
                            <p class="text-2xl font-bold text-blue-800 mt-2">{{ $totalClients }}</p>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Financial Chart -->
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="text-base font-semibold mb-4 text-center">Financeiro (Mês Atual)</h4>
                            <div class="relative h-64">
                                <canvas id="financialChart"></canvas>
                            </div>
                        </div>

                        <!-- Budget Chart -->
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="text-base font-semibold mb-4 text-center">Status dos Orçamentos</h4>
                            <div class="relative h-64">
                                <canvas id="budgetChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Financial Chart
                        const ctxFinance = document.getElementById('financialChart').getContext('2d');
                        new Chart(ctxFinance, {
                            type: 'bar',
                            data: {
                                labels: ['Receitas', 'Despesas'],
                                datasets: [{
                                    label: 'R$',
                                    data: [{{ $revenue }}, {{ $expense }}],
                                    backgroundColor: [
                                        'rgba(34, 197, 94, 0.6)', // Green
                                        'rgba(239, 68, 68, 0.6)'  // Red
                                    ],
                                    borderColor: [
                                        'rgb(34, 197, 94)',
                                        'rgb(239, 68, 68)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: {
                                    y: { beginAtZero: true }
                                }
                            }
                        });

                        // Budget Chart
                        const ctxBudget = document.getElementById('budgetChart').getContext('2d');
                        const budgetData = @json($budgetStats);
                        
                        new Chart(ctxBudget, {
                            type: 'doughnut',
                            data: {
                                labels: Object.keys(budgetData),
                                datasets: [{
                                    data: Object.values(budgetData),
                                    backgroundColor: [
                                        'rgba(59, 130, 246, 0.6)', // Blue (Open)
                                        'rgba(34, 197, 94, 0.6)',  // Green (Approved)
                                        'rgba(239, 68, 68, 0.6)',  // Red (Rejected)
                                        'rgba(234, 179, 8, 0.6)'   // Yellow (Pending)
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom' }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
