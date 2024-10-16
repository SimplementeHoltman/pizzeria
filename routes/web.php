<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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
