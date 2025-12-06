<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistema Vidraçaria') }} - Gestão Completa para Vidraceiros</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 top-0 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-bold text-blue-600">Vidraçaria<span class="text-gray-800">SaaS</span></span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 transition">Funcionalidades</a>
                    <a href="#pricing" class="text-gray-600 hover:text-blue-600 transition">Preços</a>
                    <a href="#faq" class="text-gray-600 hover:text-blue-600 transition">FAQ</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
            <nav class="-mx-3 flex flex-1 justify-end">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 tracking-tight">
                Gerencie sua Vidraçaria <br>
                <span class="text-blue-600">em um só lugar</span>
            </h1>
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                Orçamentos profissionais em segundos, controle de estoque e gestão de clientes. 
                Tudo o que você precisa para crescer o seu negócio.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-lg px-8 py-4 rounded-full font-semibold shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    Criar Conta Grátis
                </a>
                <a href="#features" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-lg px-8 py-4 rounded-full font-semibold shadow-sm transition">
                    Ver Funcionalidades
                </a>
            </div>
            <div class="mt-16 relative">
                <div class="absolute inset-0 bg-blue-600 blur-3xl opacity-10 rounded-full"></div>
                <img src="https://placehold.co/1200x600/e2e8f0/475569?text=Dashboard+Preview" alt="Dashboard Preview" class="relative rounded-xl shadow-2xl border border-gray-200 mx-auto w-full max-w-5xl">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Tudo o que você precisa</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Deixe as planilhas de lado e profissionalize sua gestão com ferramentas feitas sob medida para vidraceiros.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 3.659c0 3.074-1.8 5.523-3.996 5.523-1.218 0-2.254-.753-2.983-1.875M16 13H8m-3 7h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Orçamentos Rápidos</h3>
                    <p class="text-gray-600">Crie orçamentos detalhados com cálculo automático de m² para vidros e preços de ferragens. Envie PDF direto para o cliente.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestão de Clientes</h3>
                    <p class="text-gray-600">Mantenha o histórico completo de cada cliente, endereços de instalação e orçamentos aprovados em um só lugar.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Controle de Produção</h3>
                    <p class="text-gray-600">Acompanhe o status de cada pedido com um quadro Kanban visual. Saiba exatamente o que está em produção, pronto ou instalado.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Planos Simples e Transparentes</h2>
                <p class="text-gray-600">Escolha o plano ideal para o tamanho da sua vidraçaria.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Iniciante</h3>
                    <div class="text-4xl font-bold text-gray-900 mb-6">Grátis<span class="text-lg font-normal text-gray-500">/mês</span></div>
                    <ul class="space-y-4 mb-8 text-gray-600">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Até 10 Orçamentos/mês</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Gestão de Clientes</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Suporte por Email</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 px-6 bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold rounded-lg text-center transition">Começar Grátis</a>
                </div>

                <!-- Pro Plan -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border-2 border-blue-600 relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">MAIS POPULAR</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Profissional</h3>
                    <div class="text-4xl font-bold text-gray-900 mb-6">R$ 97<span class="text-lg font-normal text-gray-500">/mês</span></div>
                    <ul class="space-y-4 mb-8 text-gray-600">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Orçamentos Ilimitados</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Controle Financeiro</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Suporte Prioritário WhatsApp</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Domínio Personalizado</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-center transition">Assinar Agora</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <span class="text-2xl font-bold text-white">Vidraçaria<span class="text-blue-400">SaaS</span></span>
                    <p class="mt-4 text-gray-400 max-w-sm">A plataforma completa para gestão de vidraçarias. Simplifique seu dia a dia e venda mais.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Produto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white">Funcionalidades</a></li>
                        <li><a href="#pricing" class="hover:text-white">Preços</a></li>
                        <li><a href="#" class="hover:text-white">Atualizações</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Termos de Uso</a></li>
                        <li><a href="#" class="hover:text-white">Privacidade</a></li>
                        <li><a href="#" class="hover:text-white">Contato</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
                &copy; {{ date('Y') }} VidraçariaSaaS. Todos os direitos reservados.
            </div>
        </div>
    </footer>

</body>
</html>
