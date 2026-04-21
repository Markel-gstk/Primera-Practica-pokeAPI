<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Pokémon') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-row items-start gap-4">
                        <form method="GET" action="{{ route('pokemons.index') }}" class="mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre" class="border border-gray-300 rounded px-4 py-2">
                            <input type="hidden" name="generation" value="{{ request('generation') }}">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">Buscar</button>
                        </form>
                        <form method="GET" action="{{ route('pokemons.index') }}" class="mb-6 flex gap-4">
                            <select name="generation" class="border rounded px-3 py-2">
                                <option value="">Todas las generaciones</option>
                                @for ($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ request('generation') == $i ? 'selected' : '' }}>
                                        Generación {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                Filtrar
                            </button>
                        </form>
                    </div>   
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($pokemons as $pokemon)
                            <div class="border rounded p-4 text-center">
                                <a href="{{ route('pokemon.show', $pokemon->pokedex_number) }}">
                                    <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" class="mx-auto mb-2">
                                    <h3 class="font-bold">{{ ucfirst($pokemon->name) }}</h3>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{ $pokemons->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>