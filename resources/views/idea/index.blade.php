<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Formulaire de création d'idée --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('idea.store') }}">
                        @csrf
                        
                        @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">{{ session('success') }}</strong>
                        </div>
                        @endif
                        
                        @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">{{ session('error') }}</strong>
                        </div>
                        @endif

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Titre de votre idée')" />
                            <x-text-input
                                id="title"
                                type="text"
                                name="title"
                                :value="old('title')"
                                placeholder="Titre de votre idée"
                                class="block w-full"
                            />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description de votre idée')" />
                            <textarea
                                id="description"
                                name="description"
                                placeholder="Décrivez votre idée"
                                class="block w-full"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <x-primary-button>{{ __('Soumettre l\'idée') }}</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- Liste des idées --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-4">Idées récentes</h2>
                    
                    @if($ideas->isEmpty())
                        <p class="text-gray-500">Aucune idée n'a été publiée pour le moment.</p>
                    @else
                        @foreach($ideas as $idea)
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-xl font-bold">{{ $idea->title }}</h3>
                                    <small class="text-gray-500">
                                        Publiée par {{ $idea->user?->name ?? 'Utilisateur inconnu' }}
                                        le {{ $idea->created_at->format('d/m/Y à H:i') }}
                                    </small>
                                </div>
                                
                                <p class="text-gray-700 mb-4">{{ $idea->description }}</p>
                                
                                {{-- Section des commentaires --}}
                                <div class="mt-4">
                                    <h4 class="font-semibold mb-2">Commentaires ({{ $idea->comments->count() }})</h4>
                                    
                                    @foreach($idea->comments as $comment)
                                        <div class="bg-gray-100 p-3 rounded-lg mb-2">
                                            <div class="flex justify-between items-center">
                                                <p>{{ $comment->content }}</p>
                                                <small class="text-gray-500">
                                                    {{ $comment->user->name }} 
                                                    le {{ $comment->created_at->format('d/m/Y à H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    {{-- Formulaire de commentaire --}}
                                    <form method="POST" action="{{ route('comments.store', $idea) }}" class="mt-4">
                                        @csrf
                                        <textarea 
                                            name="content" 
                                            placeholder="Ajouter un commentaire"
                                            class="w-full"
                                        ></textarea>
                                        <x-primary-button class="mt-2">Commenter</x-primary-button>
                                    </form>
                                </div>
                                
                                {{-- Actions pour le propriétaire de l'idée --}}
                                @if(auth()->id() === $idea->user_id)
                                    <div class="mt-4 flex space-x-2">
                                        <x-secondary-button 
                                        x-onclick="window.location.href='{{ route('idea.edit', $idea) }}'"
                                        >
                                            Modifier
                                        </x-secondary-button>
                                        <form action="{{ route('idea.destroy', $idea) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette idée ?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>Supprimer</x-danger-button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $ideas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Optionnel : script pour gérer les messages flash
        setTimeout(function() {
            const flashMessages = document.querySelectorAll('[role="alert"]');
            flashMessages.forEach(function(message) {
                message.style.transition = 'opacity 1s';
                message.style.opacity = 0;
                setTimeout(() => message.remove(), 1000);
            });
        }, 3000);
    </script>
    @endpush
</x-app-layout>