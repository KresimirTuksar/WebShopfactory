<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\SingleProductController;
use App\Http\Controllers\ProductFilterController;
use App\Http\Controllers\OrderController;

// Ruta za izlistavanje svih proizvoda s paginacijom i uzimanje u obzir cijene
Route::get('/products', [ProductController::class, 'index']);

// Ruta za izlistavanje proizvoda unutar određene kategorije s paginacijom i uzimanje u obzir cijene
Route::get('/categories/{category_id}/products', [CategoryProductController::class, 'index']);

// Ruta za prikaz jednog proizvoda
Route::get('/products/{product_sku}', [SingleProductController::class, 'show']);

// Ruta za filtriranje proizvoda
Route::get('/products/filter', [ProductFilterController::class, 'filter']);

// Ruta za dodavanje narudžbe sa listom proizvoda
Route::post('/orders', [OrderController::class, 'store']);
