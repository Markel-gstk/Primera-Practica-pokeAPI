<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    {{ __("You're logged in!") }}
                    <br><br>
                    @if ($mostrarFormulario < 1)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="1">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de primera generacion') }}
                            </button>
                        </form>
                    @endif
                    @if ($mostrarFormulario < 152)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la segunda generacion') }}
                            </button>
                        </form>                        
                    @endif
                    @if ($mostrarFormulario < 252)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la tercera generacion') }}
                            </button>
                        </form>
                    @endif
                    @if ($mostrarFormulario < 387)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la cuarta generacion') }}
                            </button>
                        </form>
                    @endif
                    @if ($mostrarFormulario < 494)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="5">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la quinta generacion') }}
                            </button>
                        </form>
                    @endif
                    @if ($mostrarFormulario < 649)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la sexta generacion') }}
                            </button>
                        </form>
                    @endif
                    @if ($mostrarFormulario < 721)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="7">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la septima generacion') }}
                            </button>
                        </form>
                    @endif
                    @if ($mostrarFormulario < 809)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="8">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la octava generacion') }}
                            </button>
                        </form>
                    @endif
                    @if ($mostrarFormulario < 905)
                        <form action="/admin/generar-datos" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="generation" value="9">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generar Datos de los pokemon de la novena generacion') }}
                            </button>
                        </form>
                    @else
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ __('¡Todos los datos de los Pokémon han sido generados!') }}
                        </div>
                    @endif
                    <br>
                    <a href="{{ route('pokemons.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">
                        Ver Lista de Pokémon
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
