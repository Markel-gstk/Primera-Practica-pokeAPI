<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class type extends Model
{
    protected $fillable = ['name'];

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class);
    }
}
