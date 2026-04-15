<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pokemon extends Model
{
    protected $fillable = ['pokedex_number', 'name', 'sprite'];

    public function types(){
        return $this->belongsToMany(Type::class);
    }
}
