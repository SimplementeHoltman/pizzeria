<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;

// Ruta principal y otras vistas informativas
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

// Ruta del dashboard protegida por autenticación
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Ruta para los detalles del producto
Route::get('/productos/{id}', [ProductController::class, 'show'])->name('productos.show');

// Rutas para el carrito de compras
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/dashboard', [CartController::class, 'showCart'])->name('dashboard')->middleware('auth');
Route::post('/cart/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::post('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

// Rutas para direcciones
Route::get('/dashboard', [AddressController::class, 'index'])->name('dashboard');
Route::post('/addresses', [AddressController::class, 'store'])->name('address.store');
Route::post('/addresses', [App\Http\Controllers\AddressController::class, 'store'])->name('address.store');
Route::delete('/addresses/{id}', [App\Http\Controllers\AddressController::class, 'destroy'])->name('address.destroy');
