<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\PokemonAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/perfil', function () { return  view('perfil'); })->middleware('auth');

Route::get('/pokemons', [PokemonController::class, 'index'])->middleware('auth')->name('pokemons.index');

Route::get('/pokemon/{id}', [PokemonController::class, 'show'])->name('pokemon.show');

Route::get('/admin/generar-datos', function () {
    return redirect('/dashboard')->with('error', 'Por favor, usa el formulario en el dashboard para generar datos.');
})->middleware(['auth', \App\Http\Middleware\AdminOnly::class]);

Route::post('/admin/generar-datos', [PokemonAdminController::class, 'generar'])->middleware(['auth', \App\Http\Middleware\AdminOnly::class])->name('admin.generar');