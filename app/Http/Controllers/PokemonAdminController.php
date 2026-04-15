<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Pokemon;
use App\Models\Evolution;

class PokemonAdminController extends Controller
{
    public function generar(Request $request)
    {
        set_time_limit(0);
        // Ejecutar el comando Artisan para procesar los datos
        Artisan::call('app:generate-pokemon-data');

        return redirect()->back()->with('success', 'Datos de Pokémon generados correctamente.');
    }

    private function procesarCadena(array $chain): void
    {
        $from = $chain['species']['name'];

        foreach ($chain['evolves_to'] as $evo) {
            $to = $evo['species']['name'];

            $fromPokemon = Pokemon::where('name', $from)->first();
            $toPokemon = Pokemon::where('name', $to)->first();

            if ($fromPokemon && $toPokemon) {
                Evolution::updateOrCreate(
                    [
                        'pokemon_id' => $fromPokemon->id,
                        'to_pokemon_id' => $toPokemon->id,
                    ],
                    [
                        'min_level' => $evo['evolution_details'][0]['min_level'] ?? null,
                        'trigger' => $evo['evolution_details'][0]['trigger']['name'] ?? null,
                        'item' => $evo['evolution_details'][0]['item']['name'] ?? null,
                    ]
                );
            }

            $this->procesarCadena($evo);
        }
    }
}

