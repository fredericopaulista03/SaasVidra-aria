<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quadro de Produção') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="kanbanBoard()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 overflow-x-auto">
            <div class="flex space-x-4 min-w-max pb-4">
                @foreach ($columns as $column)
                    <div class="w-80 flex-shrink-0 flex flex-col bg-gray-100 rounded-lg p-3"
                         data-column-id="{{ $column->id }}"
                         @dragover.prevent
                         @dragenter.prevent
                         @drop="drop($event, {{ $column->id }})">
                        
                        <!-- Column Header -->
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-gray-700">{{ $column->name }}</h3>
                            <span class="bg-gray-200 text-gray-600 text-xs font-semibold px-2 py-1 rounded-full">{{ $column->cards->count() }}</span>
                        </div>

                        <!-- Cards Container -->
                        <div class="flex-1 space-y-3 min-h-[100px]">
                            @foreach ($column->cards as $card)
                                <div class="bg-white p-4 rounded shadow-sm cursor-move border-l-4 border-blue-500 hover:shadow-md transition"
                                     draggable="true"
                                     @dragstart="dragStart($event, {{ $card->id }})"
                                     data-card-id="{{ $card->id }}">
                                    
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-xs font-bold text-gray-500">#{{ $card->id }}</span>
                                        @if($card->budget)
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Orçamento</span>
                                        @elseif($card->order)
                                            <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded">Pedido</span>
                                        @endif
                                    </div>
                                    
                                    <h4 class="font-medium text-gray-900 mb-1">
                                        {{ $card->title ?? ($card->budget ? 'Orçamento #' . $card->budget->id : 'Item sem título') }}
                                    </h4>
                                    
                                    @if($card->budget && $card->budget->client)
                                        <div class="text-sm text-gray-600 mb-2">
                                            <span class="block">{{ $card->budget->client->name }}</span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-100">
                                        <span class="text-xs text-gray-400">{{ $card->created_at->format('d/m') }}</span>
                                        <div class="flex -space-x-2">
                                            <!-- Avatar placeholder -->
                                            <div class="w-6 h-6 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs text-white">A</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function kanbanBoard() {
            return {
                draggingCardId: null,

                dragStart(event, cardId) {
                    this.draggingCardId = cardId;
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', cardId);
                    // Add a slight delay to visual drag effect
                    setTimeout(() => {
                        event.target.classList.add('opacity-50');
                    }, 0);
                },

                drop(event, columnId) {
                    const cardId = event.dataTransfer.getData('text/plain');
                    const cardElement = document.querySelector(`[data-card-id='${cardId}']`);
                    
                    if (cardElement) {
                        cardElement.classList.remove('opacity-50');
                        
                        // Optimistic UI Update: Move card to new column in DOM
                        // In a real app with complex sorting, we'd calculate index based on drop position.
                        // For now, we just append to the end of the column.
                        const columnContainer = event.target.closest('[data-column-id]').querySelector('.space-y-3');
                        columnContainer.appendChild(cardElement);

                        // Send update to server
                        this.updateCardPosition(cardId, columnId, columnContainer.children.length);
                    }
                },

                updateCardPosition(cardId, columnId, index) {
                    fetch(`/tenant/kanban/${cardId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            kanban_column_id: columnId,
                            order_index: index
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Erro ao mover cartão.');
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Erro de conexão.');
                    });
                }
            }
        }
    </script>
</x-app-layout>
