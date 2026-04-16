<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;
use App\Models\Type;
use App\Models\Evolution;

class GeneratePokemonData extends Command
{
    protected $signature = 'app:generate-pokemon-data';
    protected $description = 'Genera datos de Pokémon desde PokeAPI';
    public function handle()
    {
        set_time_limit(0);
        $this->info('Iniciando generación de datos de Pokémon...');

        $processedChains = [];
        $evolutionChainUrls = [];

        for ($i = 1; $i <= 151; $i++) {
            $this->line("Procesando Pokémon $i...");
            $data = Http::timeout(10)->withoutVerifying()->get("https://pokeapi.co/api/v2/pokemon/$i")->json();

            $pokemon = Pokemon::updateOrCreate(
                ['pokedex_number' => $i],
                [
                    'name' => $data['name'],
                    'sprite' => $data['sprites']['front_default'],

                    // ⭐ Stats
                    'hp' => $data['stats'][0]['base_stat'],
                    'attack' => $data['stats'][1]['base_stat'],
                    'defense' => $data['stats'][2]['base_stat'],
                    'special_attack' => $data['stats'][3]['base_stat'],
                    'special_defense' => $data['stats'][4]['base_stat'],
                    'speed' => $data['stats'][5]['base_stat'],

                    // ⭐ Abilities
                    'ability1' => $data['abilities'][0]['ability']['name'],
                    'ability2' => $data['abilities'][1]['ability']['name'] ?? null,
                    'ability_hidden' => $data['abilities'][2]['ability']['name'] ?? null,
                ]
            );


            foreach ($data['types'] as $typeItem) {
                $typeName = $typeItem['type']['name'];
                $type = Type::firstOrCreate(['name' => $typeName]);
                $pokemon->types()->syncWithoutDetaching($type->id);
            }

            $speciesUrl = $data['species']['url'];
            $species = Http::timeout(10)->withoutVerifying()->get($speciesUrl)->json();
            $evolutionChainUrl = $species['evolution_chain']['url'];

            if (!isset($processedChains[$evolutionChainUrl])) {
                $processedChains[$evolutionChainUrl] = true;
                $evolutionChainUrls[] = $evolutionChainUrl;
            }
        }

        $this->info('Procesando cadenas de evolución...');
        foreach ($evolutionChainUrls as $chainUrl) {
            $evoChain = Http::timeout(10)->withoutVerifying()->get($chainUrl)->json();
            $this->procesarCadena($evoChain['chain']);
        }

        $this->info('¡Datos de Pokémon generados correctamente!');
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
