<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController; // <-- ¡Asegúrate de que esta línea esté presente!
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // 1. Rutas Resource estándar (index, create, store, etc.)
    Route::resource('clients', ClientController::class);  
    // 2. Ruta personalizada para el botón "Ver ventas"
    // Asegúrate de nombrarla para facilitar su uso en la vista Blade.
    Route::get('clients/{client}/ventas', [ClientController::class, 'showVentas'])
         ->name('clients.ventas');
    Route::resource('users', UserController::class);



});

require __DIR__.'/auth.php';
