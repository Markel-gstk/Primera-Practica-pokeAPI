<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\log;
class PokemonController extends Controller
{
    public function index(Request $request)
    {

        $query = Pokemon::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('generation') && $request->generation) {
        $query->where('generation', $request->generation);
        }

        $pokemons = $query->orderBy('pokedex_number', 'asc')->paginate(20);

        return view('pokemons.index', compact('pokemons'));
    }
    public function show($id)
    {
        $respuesta = Http::withoutVerifying()->get("https://pokeapi.co/api/v2/pokemon/{$id}");
        
        if ($respuesta->failed()) {
            abort(404, 'Pokémon no encontrado');
        }
        $pokemon = $respuesta->json();
        
        $statsProcesadas = [];
        $max = 250; //Este es el valor maximo que puede tiene una estadistica base.

        foreach ($pokemon['stats'] as $stat) {
            $nombre = ucfirst(str_replace('-', ' ', $stat['stat']['name']));
            $valor = $stat['base_stat'];
            $porcentaje = ($valor / $max) * 100;

            $statsProcesadas[] = [
                'nombre' => $nombre,
                'valor' => $valor,
                'porcentaje' => $porcentaje
            ];
        }

        // Get species for evolution
        $speciesResponse = Http::withoutVerifying()->get($pokemon['species']['url']);
        $species = $speciesResponse->json();

        // Get evolution chain
        $evolutionResponse = Http::withoutVerifying()->get($species['evolution_chain']['url']);
        $evolutionChain = $evolutionResponse->json();

        return view('pokemon', ['pokemon' => $pokemon, 'evolutionChain' => $evolutionChain, 'stats' => $statsProcesadas]);
    }
}
