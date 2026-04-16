<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {    
       $mostrarFormulario = Pokemon::count();
       return view('dashboard', compact('mostrarFormulario'));
    }
}
