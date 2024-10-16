<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Obtener todas las categorías y productos
        $categories = Category::all();
        $products = Product::all();

        // Retornar la vista con los datos
        return view('home', compact('categories', 'products'));
    }
}
