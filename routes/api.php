<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\CategoriaApiController;

// Consultar productos activos
Route::get('/productos', [ProductoApiController::class, 'index']);

// Consultar categorías activas
Route::get('/categorias', [CategoriaApiController::class, 'index']);
Route::get('/categoria', [CategoriaApiController::class, 'index']);
