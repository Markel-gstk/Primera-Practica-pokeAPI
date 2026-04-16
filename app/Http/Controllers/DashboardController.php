<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {    
       $generacionesPendientes = [];
       for ($gen = 1; $gen <= 9; $gen++) {
           $existe = Pokemon::where('generation', $gen)->exists();
           if (!$existe) {
               $generacionesPendientes[] = $gen;
           }
       }
       return view('dashboard', compact('generacionesPendientes'));
    }
}
