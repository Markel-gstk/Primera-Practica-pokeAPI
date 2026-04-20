<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Evolution;
use Illuminate\Http\Request;

class EvolutionController extends Controller
{
    public function mostrarEvo(Pokemon $pokemon)
    {
        $previous = Evolution::where('to_pokemon_id', $pokemon->id)->with('pokemon')->first();
        $next = Evolution::where('pokemon_id', $pokemon->id)->with('toPokemon')->get();

        return ['previous' => $previous, 'current' => $pokemon, 'next' => $next];
    }
}
