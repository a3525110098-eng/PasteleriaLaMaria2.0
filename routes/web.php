<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Rutas para cualquier usuario autenticado (Administrador o Empleado)
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Módulo de productos (CRUD)
    Route::resource('productos', ProductoController::class)->except(['show']);

    // Módulo de categorías (CRUD)
    Route::resource('categorias', CategoriaController::class)->except(['show']);

    Route::view('/contacto', 'contacto')->name('contacto');
    Route::view('/cotizacion', 'cotizacion')->name('cotizacion');
});

// Rutas exclusivas del Administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/usuarios', 'usuarios')->name('usuarios.index');
    Route::view('/roles', 'roles')->name('roles.index');
    Route::view('/empresa', 'empresa')->name('empresa');
});
