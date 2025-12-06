<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema para Vidraçaria - Orçamentos, Produção e Gestão Completa</title>
    <meta name="description" content="Sistema completo para vidraçarias: orçamentos inteligentes, kanban de produção, medidas otimizadas e WhatsApp automático. Pare de perder tempo e dinheiro!">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); } 50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); } }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 text-gray-900">

    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-lg fixed w-full z-50 top-0 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0">
                    <span class="text-3xl font-black bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">VidroSmart</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#solucao" class="text-gray-700 hover:text-blue-600 font-medium transition">Solução</a>
                    <a href="#beneficios" class="text-gray-700 hover:text-blue-600 font-medium transition">Benefícios</a>
                    <a href="#precos" class="text-gray-700 hover:text-blue-600 font-medium transition">Preços</a>
                    <a href="#depoimentos" class="text-gray-700 hover:text-blue-600 font-medium transition">Depoimentos</a>
                    <a href="#faq" class="text-gray-700 hover:text-blue-600 font-medium transition">FAQ</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-6 py-3 rounded-full font-bold shadow-lg hover:shadow-xl transition transform hover:scale-105">Começar Grátis</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - AIDA: Attention -->
    <section class="pt-32 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-cyan-500/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-block mb-6 px-6 py-2 bg-gradient-to-r from-blue-600/10 to-cyan-500/10 rounded-full border border-blue-200">
                    <span class="text-blue-700 font-bold text-sm">🚀 Mais de 500 vidraçarias já economizam tempo e dinheiro</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 leading-tight">
                    Pare de Perder <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">Dinheiro</span> com Orçamentos Desorganizados
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-700 mb-6 font-medium">
                    Sistema completo para vidraçarias que <span class="text-blue-600 font-bold">automatiza orçamentos</span>, organiza produção e <span class="text-blue-600 font-bold">aumenta suas vendas em até 40%</span>
                </p>
                
                <p class="text-lg text-gray-600 mb-10">
                    ✅ Orçamentos em 2 minutos • ✅ WhatsApp automático • ✅ Kanban de produção • ✅ Zero planilhas
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-5 mb-12">
                    <a href="{{ route('register') }}" class="group bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white text-xl px-10 py-5 rounded-full font-black shadow-2xl hover:shadow-3xl transition-all transform hover:scale-105 pulse-glow">
                        🎯 Começar Grátis Agora
                        <span class="ml-2 group-hover:translate-x-1 inline-block transition-transform">→</span>
                    </a>
                    <a href="#solucao" class="bg-white hover:bg-gray-50 text-gray-800 border-2 border-gray-300 text-xl px-10 py-5 rounded-full font-bold shadow-lg hover:shadow-xl transition-all">
                        Ver Como Funciona
                    </a>
                </div>
                
                <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto text-center">
                    <div>
                        <div class="text-4xl font-black text-blue-600">500+</div>
                        <div class="text-sm text-gray-600 font-medium">Vidraçarias Ativas</div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-blue-600">40%</div>
                        <div class="text-sm text-gray-600 font-medium">Mais Vendas</div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-blue-600">15h</div>
                        <div class="text-sm text-gray-600 font-medium">Economizadas/Semana</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feita para Vidraçarias - AIDA: Interest -->
    <section id="solucao" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-blue-600 font-bold text-sm uppercase tracking-wide">Solução Completa</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-4 mb-6">Feita Especialmente para Vidraçarias</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Chega de perder tempo com planilhas e orçamentos manuais. Tudo que você precisa em um só lugar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Orçamentos Inteligentes -->
                <div class="group bg-gradient-to-br from-blue-50 to-cyan-50 p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-blue-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📊 Orçamentos Inteligentes</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">Crie orçamentos profissionais em <strong>menos de 2 minutos</strong>. Cálculo automático de m², preços de vidros, ferragens e mão de obra. Envie PDF direto para o WhatsApp do cliente.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li>✓ Cálculo automático de áreas</li>
                        <li>✓ Catálogo de produtos integrado</li>
                        <li>✓ Envio automático por WhatsApp</li>
                    </ul>
                </div>

                <!-- Medidas Otimizadas -->
                <div class="group bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-purple-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📐 Medidas Otimizadas</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">Registre medidas com precisão, calcule aproveitamento de chapas e <strong>reduza desperdício em até 30%</strong>. Ideal para box, espelhos e temperados.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li>✓ Otimização de corte</li>
                        <li>✓ Histórico de medições</li>
                        <li>✓ Alertas de conferência</li>
                    </ul>
                </div>

                <!-- Kanban de Produção -->
                <div class="group bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-green-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">🎯 Kanban de Produção</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">Visualize todo o fluxo: Orçamento → Medição → Produção → Instalação. <strong>Nunca mais perca o controle</strong> de onde está cada pedido.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li>✓ Arraste e solte pedidos</li>
                        <li>✓ Status em tempo real</li>
                        <li>✓ Notificações automáticas</li>
                    </ul>
                </div>

                <!-- WhatsApp Automático -->
                <div class="group bg-gradient-to-br from-orange-50 to-amber-50 p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-orange-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-amber-500 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">💬 WhatsApp Automático</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">Envie orçamentos, lembretes de medição e confirmações de instalação <strong>automaticamente</strong>. Seus clientes sempre informados.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li>✓ Mensagens personalizadas</li>
                        <li>✓ Agendamento automático</li>
                        <li>✓ Confirmação de leitura</li>
                    </ul>
                </div>

                <!-- Instalação Organizada -->
                <div class="group bg-gradient-to-br from-indigo-50 to-blue-50 p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-indigo-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📅 Instalação Organizada</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">Agenda inteligente com rotas otimizadas. <strong>Evite retrabalho</strong> e melhore a experiência do cliente com instalações pontuais.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li>✓ Calendário visual</li>
                        <li>✓ Rotas otimizadas</li>
                        <li>✓ Checklist de instalação</li>
                    </ul>
                </div>

                <!-- Gestão de Equipe -->
                <div class="group bg-gradient-to-br from-red-50 to-rose-50 p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-red-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-600 to-rose-500 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">👥 Gestão Completa da Equipe</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">Controle permissões, acompanhe produtividade e <strong>saiba exatamente</strong> quem está fazendo o quê. Relatórios detalhados por colaborador.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li>✓ Níveis de acesso</li>
                        <li>✓ Relatórios de performance</li>
                        <li>✓ Comissões automáticas</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Por que seu negócio precisa - AIDA: Desire + Gatilhos Mentais -->
    <section class="py-24 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black mb-6">Por Que Sua Vidraçaria Precisa Disso <span class="text-red-400">AGORA</span>?</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">Enquanto você lê isso, seus concorrentes já estão automatizando e vendendo mais</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20">
                    <div class="text-5xl mb-4">⏰</div>
                    <h3 class="text-2xl font-bold mb-4 text-yellow-400">URGÊNCIA</h3>
                    <p class="text-gray-200 leading-relaxed">Cada dia sem automação = <strong class="text-white">R$ 500+ perdidos</strong> em orçamentos atrasados, erros de medição e clientes que desistem.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20">
                    <div class="text-5xl mb-4">💰</div>
                    <h3 class="text-2xl font-bold mb-4 text-green-400">OPORTUNIDADE</h3>
                    <p class="text-gray-200 leading-relaxed">Vidraçarias que automatizam <strong class="text-white">faturam 40% a mais</strong> no primeiro ano. Seus concorrentes já descobriram isso.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20">
                    <div class="text-5xl mb-4">🏆</div>
                    <h3 class="text-2xl font-bold mb-4 text-blue-400">AUTORIDADE</h3>
                    <p class="text-gray-200 leading-relaxed"><strong class="text-white">500+ vidraçarias</strong> em todo Brasil já confiam. Sistema desenvolvido POR vidraceiros PARA vidraceiros.</p>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('register') }}" class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-gray-900 text-2xl px-12 py-6 rounded-full font-black shadow-2xl transition-all transform hover:scale-105">
                    🚀 Sim! Quero Vender Mais Agora
                </a>
                <p class="mt-4 text-gray-400">✅ Grátis para sempre • ✅ Sem cartão • ✅ Ative em 5 minutos</p>
            </div>
        </div>
    </section>

    <!-- Prova Social -->
    <section id="depoimentos" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold text-sm uppercase tracking-wide">Prova Social</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-4 mb-6">Veja o Que Outros Vidraceiros Estão Dizendo</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">JC</div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">João Carlos</div>
                            <div class="text-sm text-gray-600">Vidraçaria Premium - SP</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-2xl mb-4">★★★★★</div>
                    <p class="text-gray-700 italic">"Antes levava 30min para fazer um orçamento. Agora faço em 2min. <strong>Minhas vendas aumentaram 35% em 3 meses!</strong>"</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">MS</div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Maria Silva</div>
                            <div class="text-sm text-gray-600">Box & Espelhos - RJ</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-2xl mb-4">★★★★★</div>
                    <p class="text-gray-700 italic">"O Kanban mudou minha vida! <strong>Zero retrabalho e clientes muito mais satisfeitos.</strong>"</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-600 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">RS</div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Roberto Santos</div>
                            <div class="text-sm text-gray-600">Vidros Temperados - MG</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-2xl mb-4">★★★★★</div>
                    <p class="text-gray-700 italic">"Economizo 15h por semana. <strong>Agora uso esse tempo para prospectar!</strong>"</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-3xl p-12 text-white text-center">
                <h3 class="text-3xl font-black mb-8">Números Que Falam Por Si</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div><div class="text-5xl font-black mb-2">500+</div><div class="text-blue-100">Vidraçarias Ativas</div></div>
                    <div><div class="text-5xl font-black mb-2">50K+</div><div class="text-blue-100">Orçamentos Criados</div></div>
                    <div><div class="text-5xl font-black mb-2">40%</div><div class="text-blue-100">Aumento em Vendas</div></div>
                    <div><div class="text-5xl font-black mb-2">98%</div><div class="text-blue-100">Satisfação</div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefícios -->
    <section id="beneficios" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Tudo Que Você Ganha</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="flex items-start space-x-4 p-6 bg-blue-50 rounded-xl"><div class="text-3xl">⚡</div><div><h4 class="font-bold text-gray-900 mb-2">Orçamentos em 2 Minutos</h4><p class="text-gray-600 text-sm">Atenda mais clientes por dia</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-green-50 rounded-xl"><div class="text-3xl">💰</div><div><h4 class="font-bold text-gray-900 mb-2">Aumente Vendas em 40%</h4><p class="text-gray-600 text-sm">Responda rápido e feche mais</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-purple-50 rounded-xl"><div class="text-3xl">📐</div><div><h4 class="font-bold text-gray-900 mb-2">Zero Erros de Medição</h4><p class="text-gray-600 text-sm">Evite desperdício e retrabalho</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-orange-50 rounded-xl"><div class="text-3xl">📱</div><div><h4 class="font-bold text-gray-900 mb-2">WhatsApp Automático</h4><p class="text-gray-600 text-sm">Clientes sempre informados</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-red-50 rounded-xl"><div class="text-3xl">🎯</div><div><h4 class="font-bold text-gray-900 mb-2">Controle Total</h4><p class="text-gray-600 text-sm">Kanban visual em tempo real</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-cyan-50 rounded-xl"><div class="text-3xl">⏱️</div><div><h4 class="font-bold text-gray-900 mb-2">Economize 15h/Semana</h4><p class="text-gray-600 text-sm">Chega de planilhas</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-indigo-50 rounded-xl"><div class="text-3xl">📊</div><div><h4 class="font-bold text-gray-900 mb-2">Relatórios Automáticos</h4><p class="text-gray-600 text-sm">Saiba quanto está faturando</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-pink-50 rounded-xl"><div class="text-3xl">👥</div><div><h4 class="font-bold text-gray-900 mb-2">Gestão de Equipe</h4><p class="text-gray-600 text-sm">Controle quem faz o quê</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-yellow-50 rounded-xl"><div class="text-3xl">🔒</div><div><h4 class="font-bold text-gray-900 mb-2">Dados 100% Seguros</h4><p class="text-gray-600 text-sm">Backup automático</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-emerald-50 rounded-xl"><div class="text-3xl">📈</div><div><h4 class="font-bold text-gray-900 mb-2">Cresça Sem Limites</h4><p class="text-gray-600 text-sm">Sistema escala com você</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-rose-50 rounded-xl"><div class="text-3xl">🎓</div><div><h4 class="font-bold text-gray-900 mb-2">Suporte Especializado</h4><p class="text-gray-600 text-sm">Time que entende vidraçaria</p></div></div>
                <div class="flex items-start space-x-4 p-6 bg-violet-50 rounded-xl"><div class="text-3xl">🚀</div><div><h4 class="font-bold text-gray-900 mb-2">Ative em 5 Minutos</h4><p class="text-gray-600 text-sm">Comece hoje mesmo</p></div></div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="precos" class="py-24 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold text-sm uppercase">Preços Transparentes</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-4 mb-6">Escolha o Plano Ideal</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white p-10 rounded-3xl shadow-lg border-2 border-gray-200">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-2">Iniciante</h3>
                        <div class="text-5xl font-black mb-2">Grátis</div>
                        <p class="text-gray-600">Para sempre</p>
                    </div>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-start"><svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>10 orçamentos/mês</span></li>
                        <li class="flex items-start"><svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Gestão de clientes</span></li>
                        <li class="flex items-start"><svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Suporte por email</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-4 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold rounded-xl text-center transition">Começar Grátis</a>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-cyan-500 p-10 rounded-3xl shadow-2xl border-4 border-yellow-400 relative transform scale-105">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-yellow-400 text-gray-900 px-6 py-2 rounded-full font-black text-sm">🔥 MAIS POPULAR</div>
                    <div class="text-center mb-8 text-white">
                        <h3 class="text-2xl font-bold mb-2">Profissional</h3>
                        <div class="text-5xl font-black mb-2">R$ 97</div>
                        <p class="text-blue-100">por mês</p>
                    </div>
                    <ul class="space-y-4 mb-10 text-white">
                        <li class="flex items-start"><svg class="w-6 h-6 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span><strong>Ilimitado</strong></span></li>
                        <li class="flex items-start"><svg class="w-6 h-6 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Kanban produção</span></li>
                        <li class="flex items-start"><svg class="w-6 h-6 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>WhatsApp auto</span></li>
                        <li class="flex items-start"><svg class="w-6 h-6 text-yellow-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Gestão equipe</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-black rounded-xl text-center transition">🚀 Assinar Agora</a>
                </div>

                <div class="bg-white p-10 rounded-3xl shadow-lg border-2 border-gray-200">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-2">Empresarial</h3>
                        <div class="text-5xl font-black mb-2">R$ 197</div>
                        <p class="text-gray-600">por mês</p>
                    </div>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-start"><svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Tudo do Pro</span></li>
                        <li class="flex items-start"><svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Múltiplas lojas</span></li>
                        <li class="flex items-start"><svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>API personalizada</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold rounded-xl text-center transition">Falar com Vendas</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Perguntas Frequentes</h2>
            </div>

            <div class="space-y-6">
                <details class="group bg-gray-50 rounded-2xl p-6 hover:bg-gray-100">
                    <summary class="flex justify-between cursor-pointer list-none"><span class="text-lg font-bold">O que é um CRM para vidraçaria?</span><span class="text-blue-600 text-2xl group-open:rotate-45 transition">+</span></summary>
                    <p class="mt-4 text-gray-700">Sistema completo feito para vidraçarias. Organiza orçamentos, clientes, produção e instalações em um só lugar.</p>
                </details>

                <details class="group bg-gray-50 rounded-2xl p-6 hover:bg-gray-100">
                    <summary class="flex justify-between cursor-pointer list-none"><span class="text-lg font-bold">Como funciona o software para orçamento?</span><span class="text-blue-600 text-2xl group-open:rotate-45 transition">+</span></summary>
                    <p class="mt-4 text-gray-700">Cadastre produtos com preços. Selecione o trabalho, informe medidas e o sistema calcula tudo. PDF pronto em 2 minutos.</p>
                </details>

                <details class="group bg-gray-50 rounded-2xl p-6 hover:bg-gray-100">
                    <summary class="flex justify-between cursor-pointer list-none"><span class="text-lg font-bold">Serve para box, espelhos e temperados?</span><span class="text-blue-600 text-2xl group-open:rotate-45 transition">+</span></summary>
                    <p class="mt-4 text-gray-700">Sim! Funciona para TODOS os tipos: box, espelhos, guarda-corpos, janelas, portas, fachadas, temperados e laminados.</p>
                </details>

                <details class="group bg-gray-50 rounded-2xl p-6 hover:bg-gray-100">
                    <summary class="flex justify-between cursor-pointer list-none"><span class="text-lg font-bold">Como organizar medidas e produção?</span><span class="text-blue-600 text-2xl group-open:rotate-45 transition">+</span></summary>
                    <p class="mt-4 text-gray-700">Kanban visual mostra cada pedido: Orçamento → Medição → Produção → Instalação. Arraste entre colunas e todos veem em tempo real.</p>
                </details>

                <details class="group bg-gray-50 rounded-2xl p-6 hover:bg-gray-100">
                    <summary class="flex justify-between cursor-pointer list-none"><span class="text-lg font-bold">Preciso de conhecimento técnico?</span><span class="text-blue-600 text-2xl group-open:rotate-45 transition">+</span></summary>
                    <p class="mt-4 text-gray-700">Não! Se usa WhatsApp, vai saber usar. Sistema simples com tutoriais e suporte especializado.</p>
                </details>

                <details class="group bg-gray-50 rounded-2xl p-6 hover:bg-gray-100">
                    <summary class="flex justify-between cursor-pointer list-none"><span class="text-lg font-bold">Posso testar antes de pagar?</span><span class="text-blue-600 text-2xl group-open:rotate-45 transition">+</span></summary>
                    <p class="mt-4 text-gray-700">Sim! Plano GRÁTIS para sempre com 10 orçamentos/mês. Sem cartão de crédito.</p>
                </details>

                <details class="group bg-gray-50 rounded-2xl p-6 hover:bg-gray-100">
                    <summary class="flex justify-between cursor-pointer list-none"><span class="text-lg font-bold">Funciona no celular?</span><span class="text-blue-600 text-2xl group-open:rotate-45 transition">+</span></summary>
                    <p class="mt-4 text-gray-700">Sim! Funciona em celulares, tablets e computadores. Faça orçamentos de qualquer lugar.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-24 bg-gradient-to-br from-blue-600 via-cyan-500 to-blue-600 text-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-6xl font-black mb-6">Pronto Para Transformar Sua Vidraçaria?</h2>
            <p class="text-xl mb-4 text-blue-100">Junte-se a 500+ vidraceiros que já automatizaram</p>
            <p class="text-lg mb-12 text-blue-100">⏰ Cada dia que passa é dinheiro deixado na mesa</p>
            
            <a href="{{ route('register') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-2xl px-16 py-6 rounded-full font-black shadow-2xl transition-all transform hover:scale-105 mb-6">
                🚀 Começar Grátis Agora
            </a>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6 text-blue-100">
                <span>✅ Grátis para sempre</span>
                <span>✅ Sem cartão</span>
                <span>✅ Ative em 5min</span>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-2">
                    <span class="text-3xl font-black bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">VidroSmart</span>
                    <p class="mt-4 text-gray-400">Sistema completo para vidraçarias que querem vender mais e trabalhar menos.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Produto</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#solucao" class="hover:text-white">Funcionalidades</a></li>
                        <li><a href="#precos" class="hover:text-white">Preços</a></li>
                        <li><a href="#faq" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Empresa</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white">Sobre</a></li>
                        <li><a href="#" class="hover:text-white">Contato</a></li>
                        <li><a href="#" class="hover:text-white">Suporte</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} VidroSmart. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>
