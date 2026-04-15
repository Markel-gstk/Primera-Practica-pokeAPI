<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;
use App\Models\Type;

class PokemonAdminController extends Controller
{
    public function generar()
    {
        for ($i= 1; $i <= 151; $i++) {
            $data = Http::withoutVerifying()->get("https://pokeapi.co/api/v2/pokemon/$i")->json();

            $pokemon = Pokemon:: updateOrCreate(
                ['pokedex_number'=> $i],
                ['name' => $data['name'], 'sprite' => $data['sprites']['front_default']]
            );

            foreach ($data['types'] as $type) {
                $typeName = $type['type']['name'];
                $type = Type::firstOrCreate(['name' => $typeName]);
                $pokemon->types()->syncWithoutDetaching($type->id);
            }
            
        }

        return redirect()->back()->with('success', 'Datos de Pokémon generados correctamente.');
    }
}
