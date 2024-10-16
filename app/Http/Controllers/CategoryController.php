<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Obtener todas las categorías con sus productos relacionados
        $categories = Category::with('products')->get();

        // Retornar la vista con las categorías y productos
        return view('home', compact('categories'));
    }
}
