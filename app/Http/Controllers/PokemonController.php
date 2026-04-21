<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Evolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\EvolutionController;

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
        $pokemon = Pokemon::where('pokedex_number', $id)->with('types')->firstOrFail();
        
 
        $max = 250; //Este es el valor maximo que puede tiene una estadistica base.

        $statsProcesadas = [
            [
                'nombre' => 'HP',
                'valor' => $pokemon->hp,
                'porcentaje' => ($pokemon->hp / $max) * 100
            ],
            [
                'nombre' => 'Ataque',
                'valor' => $pokemon->attack,
                'porcentaje' => ($pokemon->attack / $max) * 100
            ],
            [
                'nombre' => 'Defensa',
                'valor' => $pokemon->defense,
                'porcentaje' => ($pokemon->defense / $max) * 100
            ],
            [
                'nombre' => 'Atq. Esp.',
                'valor' => $pokemon->special_attack,
                'porcentaje' => ($pokemon->special_attack / $max) * 100
            ],
            [
                'nombre' => 'Def. Esp.',
                'valor' => $pokemon->special_defense,
                'porcentaje' => ($pokemon->special_defense / $max) * 100
            ],
            [
                'nombre' => 'Velocidad',
                'valor' => $pokemon->speed,
                'porcentaje' => ($pokemon->speed / $max) * 100
            ],
        ];

        // Get evolution chain
        $evolutionChain = (new EvolutionController())->mostrarEvo($pokemon->id);
        return view('pokemon', ['pokemon' => $pokemon, 'evolutionChain' => $evolutionChain, 'stats' => $statsProcesadas]);
    }
}
