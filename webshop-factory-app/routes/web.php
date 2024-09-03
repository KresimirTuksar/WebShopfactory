<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\SingleProductController;

Route::get('/', function () {
    return view('welcome');
});


// Ruta za izlistavanje svih proizvoda s paginacijom i uzimanje u obzir cijene
Route::get('/products', [ProductController::class, 'index']);

// Ruta za izlistavanje proizvoda unutar određene kategorije s paginacijom i uzimanje u obzir cijene
Route::get('/categories/{category_id}/products', [CategoryProductController::class, 'index']);


// Ruta za prikaz jednog proizvoda
Route::get('/products/product/{product_sku}', [SingleProductController::class, 'show']);
