<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pokemon extends Model
{
    protected $fillable = ['pokedex_number', 'name', 'sprite', 'hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed', 'ability1', 'ability2', 'ability_hidden'];

    public function types(){
        return $this->belongsToMany(Type::class);
    }
}
