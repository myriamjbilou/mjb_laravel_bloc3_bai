<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consultation des logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Formulaire de filtre -->
                <form method="GET" action="{{ route('logs.index') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="start_date" class="block font-medium text-sm text-gray-700">Date de début</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block font-medium text-sm text-gray-700">Date de fin</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300">
                                Filtrer
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Tableau des logs -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-200 px-4 py-2 text-left">ID</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Nom</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Action</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">IP</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $log->id }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $log->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $log->action }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $log->ip_address }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-200 px-4 py-2 text-center">Aucun log trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
