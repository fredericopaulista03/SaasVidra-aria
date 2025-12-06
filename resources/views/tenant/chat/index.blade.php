<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat WhatsApp') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex h-[600px]">
                
                <!-- Sidebar (Clients) -->
                <div class="w-1/3 border-r border-gray-200 p-4 overflow-y-auto">
                    <h3 class="font-semibold text-gray-700 mb-4">Conversas</h3>
                    <div class="space-y-2">
                        @foreach($clients as $client)
                            <div class="p-3 hover:bg-gray-50 rounded cursor-pointer flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($client->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $client->name }}</div>
                                    <div class="text-sm text-gray-500 truncate">Clique para iniciar conversa</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="w-2/3 flex flex-col">
                    <!-- Messages -->
                    <div class="flex-1 p-4 overflow-y-auto bg-gray-50 space-y-4" id="messages-container">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->direction == 'outbound' ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[70%] rounded-lg p-3 {{ $message->direction == 'outbound' ? 'bg-green-100 text-green-900' : 'bg-white text-gray-900 shadow-sm' }}">
                                    <div class="text-xs text-gray-500 mb-1">
                                        {{ $message->direction == 'outbound' ? 'Você' : ($message->client->name ?? 'Cliente') }} - {{ $message->created_at->format('H:i') }}
                                    </div>
                                    <p>{{ $message->content }}</p>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($messages->isEmpty())
                            <div class="text-center text-gray-500 mt-10">
                                Nenhuma mensagem ainda. Inicie uma conversa!
                            </div>
                        @endif
                    </div>

                    <!-- Input -->
                    <div class="p-4 border-t border-gray-200 bg-white">
                        <form action="{{ route('tenant.chat.store') }}" method="POST" class="flex space-x-2">
                            @csrf
                            <select name="client_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-1/3" required>
                                <option value="">Selecione o Cliente...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="content" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Digite sua mensagem..." required>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Enviar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    </script>
</x-app-layout>
