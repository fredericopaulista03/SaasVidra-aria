<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Template: ') }} {{ ucfirst(str_replace('-', ' ', $emailTemplate->name)) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('landlord.email-templates.update', $emailTemplate) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Subject -->
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Assunto do Email
                            </label>
                            <input type="text" name="subject" id="subject" 
                                   value="{{ old('subject', $emailTemplate->subject) }}" 
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Conteúdo do Email (HTML)
                            </label>
                            <textarea name="content" id="content" rows="15" required
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm font-mono text-sm">{{ old('content', $emailTemplate->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Variables Help -->
                        @if($emailTemplate->variables)
                            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <h4 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">Variáveis Disponíveis:</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(json_decode($emailTemplate->variables) as $variable)
                                        <code class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded text-sm">
                                            {{ '{{' . $variable . '}}' }}
                                        </code>
                                    @endforeach
                                </div>
                                <p class="text-sm text-blue-600 dark:text-blue-300 mt-2">
                                    Use estas variáveis no assunto e no conteúdo. Elas serão substituídas pelos valores reais ao enviar o email.
                                </p>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('landlord.email-templates.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Salvar Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
