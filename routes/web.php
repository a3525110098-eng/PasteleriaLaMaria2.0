<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
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

// Rutas para cualquier usuario autenticado y activo (Administrador o Empleado)
Route::middleware(['auth', 'activo'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Módulo de productos (CRUD)
    Route::resource('productos', ProductoController::class)->except(['show']);

    // Módulo de categorías (CRUD)
    Route::resource('categorias', CategoriaController::class)->except(['show']);

    Route::view('/contacto', 'contacto')->name('contacto');
    Route::view('/cotizacion', 'cotizacion')->name('cotizacion');
});

// Rutas exclusivas del Administrador
Route::middleware(['auth', 'activo', 'admin'])->group(function () {
    // Usuarios
    Route::resource('usuarios', UsuarioController::class)
        ->only(['index', 'store', 'edit', 'update']);
    Route::patch('/usuarios/{usuario}/estado', [UsuarioController::class, 'cambiarEstado'])
        ->name('usuarios.estado');

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

    // Empresa (un único registro)
    Route::get('/empresa', [EmpresaController::class, 'edit'])->name('empresa');
    Route::put('/empresa', [EmpresaController::class, 'update'])->name('empresa.update');
});
