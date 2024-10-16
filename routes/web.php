<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;


Route::get('/', [CategoryController::class, 'index'])->name('home');
Route::get('/categorias', [CategoryController::class, 'index'])->name('categories');
Route::get('/sobre-nosotros', function () {
    return view('about');
})->name('about');
Route::get('/contacto', function () {
    return view('contact');
})->name('contact');

// Rutas de login y registro (ya vienen incluidas en Laravel Breeze)
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Ruta para los detalles del producto
Route::get('/productos/{id}', [ProductController::class, 'show'])->name('productos.show');


// Ruta para agregar productos al carrito
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

// Ruta para mostrar el carrito (dashboard)
Route::get('/dashboard', [CartController::class, 'showCart'])->name('dashboard')->middleware('auth');
