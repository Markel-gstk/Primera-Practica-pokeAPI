<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'pokemon_id',
        'to_pokemon_id',
        'min_level',
        'trigger',
        'item',
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_id');
    }

    public function toPokemon()
    {
        return $this->belongsTo(Pokemon::class, 'to_pokemon_id');
    }
}
