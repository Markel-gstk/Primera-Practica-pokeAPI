<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Evolution;
use Illuminate\Http\Request;
use App\Http\Controllers\PokemonController;

class EvolutionController extends Controller
{
        public function mostrarEvo($pokemonId)
        {
            $pokemon = Pokemon::where('pokedex_number', $pokemonId)->firstOrFail();
        
            // 1. Obtener evoluciones previas recursivamente
            $previous = $this->getPreviousChain($pokemon);

            // 2. Obtener evoluciones siguientes recursivamente
            $next = $this->getNextChain($pokemon);

            // 3. Unir todo en una sola cadena ordenada
            return array_merge(
                $previous,
                [[
                    'pokemon' => $pokemon,
                    'method'  => null
                ]],
                $next
            );

        }

        private function getPreviousChain(Pokemon $pokemon)
        {
            $prev = Evolution::where('to_pokemon_id', $pokemon->pokedex_number)
                ->with('pokemon')
                ->first();

            if (!$prev) {
                return [];
            }

            // Recursivo: seguir hacia atrás
            return array_merge(
                $this->getPreviousChain($prev->pokemon),
                [[
                    'pokemon' => $prev->pokemon,
                    'method'  => $this->getMethod($prev)
                    
                ]]
            );
        }

        private function getNextChain(Pokemon $pokemon)
        {
            $nextEvos = Evolution::where('pokemon_id', $pokemon->pokedex_number)
                ->with('toPokemon')
                ->get();

            $result = [];

            foreach ($nextEvos as $evo) {

                if (!$evo->toPokemon) {
                    continue;
                }

                $result[] = [
                    'pokemon' => $evo->toPokemon,
                    'method'  => $this->getMethod($evo)
                ];

                $result = array_merge(
                    $result,
                    $this->getNextChain($evo->toPokemon)
                );
            }

            return $result;
        }

        private function getMethod(Evolution $evo){
            return [
                'trigger' => $evo->trigger,
                'text'    => $this->triggerMethod($evo->trigger),
                'level'   => $evo->min_level,
                'item'    => $evo->item
            ];
        }

        private function triggerMethod($trigger)
        {
            switch ($trigger) {
                case 'level-up':

                    return 'Subir de nivel';
                case 'use-item':
                    return 'Usar objeto';
                case 'trade':
                    return 'Intercambio';
                case 'shed':
                    return 'Shed';
                default:
                    return ucfirst(str_replace('-', ' ', $trigger));
            }
        }
    }


