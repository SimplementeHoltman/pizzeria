<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mostrar los detalles de un producto específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Obtener el producto por su id
        $product = Product::findOrFail($id);

        // Retornar la vista del producto con sus detalles
        return view('productos.show', compact('product'));
    }
}
