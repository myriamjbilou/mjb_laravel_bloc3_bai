<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Boîte à Idées') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('ideas.store') }}">
            @csrf
            <textarea
                name="title"
                placeholder="Titre de votre idée"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('title') }}</textarea>
            <x-input-error :messages="$errors->get('title')" class="mt-2" />

            <textarea
                name="description"
                placeholder="Décrivez votre idée"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-4"
            >{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />

            <x-primary-button class="mt-4">{{ __('Soumettre l\'idée') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
