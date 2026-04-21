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

                    <h1 class="text-2xl font-bold mb-4">{{ ucfirst($pokemon->name) }}</h1>
                    <div class="flex flex-row items-start gap-36 mb-6">
                        <div>
                            <img src="{{ $pokemon->sprite }}" alt="Imagen de {{ $pokemon->name }}" class="w-48 h-48 object-contain"><br>
                            <img src="{{ $pokemon->shiny }}" alt="Imagen de {{ $pokemon->name }}" class="w-48 h-48 object-contain">    
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
                                <li>{{ ucfirst(str_replace('-', ' ', $pokemon->ability1)) }} {{ $pokemon['is_hidden'] ? '(Oculta)' : '' }}</li>
                                @if ($pokemon->ability2 !== null)
                                    <li>{{ ucfirst(str_replace('-', ' ', $pokemon->ability2)) }} {{ $pokemon['is_hidden'] ? '(Oculta)' : '' }}</li>
                                @endif
                                @if ($pokemon->ability_hidden !== null)
                                    <li>{{ ucfirst(str_replace('-', ' ', $pokemon->ability_hidden)) }} {{ $pokemon['is_hidden'] ? '(Oculta)' : '' }}</li>
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="flex flex-row items-start gap-36 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Tipos:</h3>
                            <ul class="list-disc list-inside mb-4">
                                @foreach ($pokemon->types as $tipo)
                                    <li>{{ $tipo->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Descripción:</h3>
                            <p>{{ ucfirst($pokemon->description) }}</p>
                        </div>
                    </div>    
                    <h3 class="text-lg font-semibold mb-2">Línea Evolutiva:</h3>

                    <div class="flex flex-row items-center gap-4 overflow-x-auto">

                        @foreach ($evolutionChain as $index => $poke)
                            <div class="text-center">
                                <a href="{{ route('pokemon.show', $poke['pokemon']->pokedex_number) }}">
                                    <img src="{{ $poke['pokemon']->sprite }}" class="w-20 h-20 mx-auto">
                                    <p>{{ ucfirst($poke['pokemon']->name) }}</p>
                                    <p> @if($poke['method'] == null)
                           
                                        @elseif($poke['method']['trigger'] == 'level-up') 
                                            Nivel {{ $poke['method']['level'] }} 
                                        @elseif($poke['method']['trigger'] == 'use-item') 
                                            {{ $poke['method']['item'] }}
                                        @else 
                                            {{ $poke['method']['text'] }}
                                        @endif
                                    </p>
                                </a>
                            </div>
                            @if (count($evolutionChain) > 3)
                                <div class="text-2xl text-gray-500">|</div>
                            @elseif($index < count($evolutionChain) - 1)
                                <div class="text-2xl text-gray-500">→</div>
                            @endif
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>