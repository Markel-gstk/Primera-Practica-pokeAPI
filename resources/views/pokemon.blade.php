<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de Pokémon') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-20">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-16 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('pokemons.index') }}" class="text-blue-500 hover:text-blue-700 mb-4 inline-block">← Volver a la lista</a>

                    <h1 class="text-2xl font-bold mb-4">{{ ucfirst($pokemon['name']) }}</h1>
                    <div class="flex flex-row items-start gap-36 mb-6">
                        <div>
                            <img src="{{ $pokemon['sprites']['front_default'] }}" alt="Imagen de {{ $pokemon['name'] }}" class="w-48 h-48 object-contain"><br>
                            <img src="{{ $pokemon['sprites']['front_shiny'] }}" alt="Imagen de {{ $pokemon['name'] }}" class="w-48 h-48 object-contain">    
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Estadísticas:</h3>
                            <ul class="list-disc list-inside mb-4">
                                @foreach ($stats as $stat)
                                    <div class="mb-3">
                                        <div class="flex justify-between mb-1">
                                            <span class="font-medium w-60">{{ $stat['nombre'] }}</span>
                                            <span class="text-sm">{{ $stat['valor'] }}</span>
                                        </div>

                                        <div class="w-full bg-gray-300 rounded h-3 overflow-hidden">
                                            <div class="h-3 bg-red-600 rounded" style="width: {{ $stat['porcentaje'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Habilidades:</h3>
                            <ul class="list-disc list-inside mb-4">
                                @foreach ($pokemon['abilities'] as $ability)
                                    <li>{{ ucfirst(str_replace('-', ' ', $ability['ability']['name'])) }} {{ $ability['is_hidden'] ? '(Oculta)' : '' }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    <div class="flex flex-row items-start gap-36 mb-6">
                        <h3 class="text-lg font-semibold mb-2">Tipos:</h3>
                        <ul class="list-disc list-inside mb-4">
                            @foreach ($pokemon['types'] as $tipo)
                                <li>{{ $tipo['type']['name'] }}</li>
                            @endforeach
                        </ul>
                        <h3 class="text-lg font-semibold mb-2">Descripción:</h3>
                        <p>{{ ucfirst($pokemon['name']) }}</p>
                        @php
                            Log::info("Guardada la descripción para $name: $descriptionEs"); 
                        @endphp
                    </div>    
                    <h3 class="text-lg font-semibold mb-2">Línea Evolutiva:</h3>
                    <div class="flex flex-row items-center gap-4 overflow-x-auto">
                        @php
                            // Esta función muestra la cadena de evolución de un Pokémon
                            // $chain es la parte actual de la cadena, $details son los métodos de evolución (opcional)
                            function displayEvolution($chain, $details = null) {
                                // Si no hay URL de especie, no mostrar nada (evita errores)
                                if (!isset($chain['species']['url'])) {
                                    return;
                                }
                                
                                // Extraer el ID del Pokémon de la URL (última parte después de /)
                                $urlParts = explode('/', rtrim($chain['species']['url'], '/'));
                                $chainId = end($urlParts);
                                
                                // Crear un card estilizado para el Pokémon
                                echo '<div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center shadow-md min-w-[120px]">';
                                echo '<a href="' . route('pokemon.show', $chainId) . '" class="block">';
                                echo '<img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/' . $chainId . '.png" alt="' . $chain['species']['name'] . '" class="mx-auto mb-2 w-16 h-16" onerror="this.style.display=\'none\'">';
                                
                                // Construir el texto del método de evolución (si hay detalles)
                                $method = '';
                                if ($details) {
                                    if (isset($details['min_level'])) {
                                        $method = ' (Lv. ' . $details['min_level'] . ')'; // Nivel mínimo
                                    } elseif (isset($details['item'])) {
                                        $method = ' (' . ucfirst($details['item']['name']) . ')'; // Objeto usado
                                    } elseif (isset($details['trigger']['name'])) {
                                        $method = ' (' . ucfirst(str_replace('-', ' ', $details['trigger']['name'])) . ')'; // Trigger especial
                                    }
                                }
                                
                                // Mostrar el nombre del Pokémon con el método
                                echo '<p class="text-sm font-medium text-gray-800 dark:text-gray-200">' . ucfirst($chain['species']['name']) . $method . '</p>';
                                echo '</a>';
                                echo '</div>';

                                // Si hay evoluciones siguientes, mostrar flecha y continuar
                                if (isset($chain['evolves_to']) && count($chain['evolves_to']) > 0) {
                                    echo '<div class="text-2xl text-gray-500 mx-2">→</div>'; // Flecha
                                    echo '<div class="flex flex-row items-center gap-4">'; // Contenedor para evoluciones
                                    $first = true;
                                    foreach ($chain['evolves_to'] as $evolution) {
                                        if (!$first && count($chain['evolves_to']) < 2) {
                                            echo '<div class="text-2xl text-gray-500 mx-2">→</div>'; // Flecha entre múltiples
                                        }
                                        // Obtener detalles de esta evolución
                                        $evoDetails = $evolution['evolution_details'][0] ?? null;
                                        // Llamar recursivamente para mostrar la evolución
                                        displayEvolution($evolution, $evoDetails);
                                        $first = false;
                                    }
                                    echo '</div>';
                                }
                            }
                        
                        // Llamar a la función con la cadena inicial (sin detalles para el primero)
                        displayEvolution($evolutionChain['chain']);
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>