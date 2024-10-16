<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;



class CartController extends Controller
{
    // Método para agregar un producto al carrito
    public function addToCart($id)
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para agregar productos al carrito.');
        }

        // Obtener el producto
        $product = Product::findOrFail($id);

        // Obtener o crear el carrito activo del usuario
        $cart = Cart::firstOrCreate(
            ['usuario_id' => Auth::id(), 'estado' => 'activo'],
            ['total' => 0.00]
        );

        // Verificar si el producto ya está en el carrito
        $cartItem = CartItem::where('carretilla_id', $cart->id)
            ->where('producto_id', $product->id)
            ->first();

        if ($cartItem) {
            // Si ya está en el carrito, aumentar la cantidad
            $cartItem->cantidad += 1;
            $cartItem->save();
        } else {
            // Si no está en el carrito, agregarlo
            CartItem::create([
                'carretilla_id' => $cart->id,
                'producto_id' => $product->id,
                'cantidad' => 1,
                'precio_unitario' => $product->precio,
            ]);
        }

        // Actualizar el total del carrito
        $cart->total += $product->precio;
        $cart->save();

        return redirect()->route('dashboard')->with('success', 'Producto agregado al carrito.');
    }

    // Método para mostrar los productos en el carrito (dashboard)
    public function showCart()
    {
        // Obtener el carrito activo del usuario
        $cart = Cart::where('usuario_id', Auth::id())->where('estado', 'activo')->first();

        if (!$cart) {
            return view('dashboard', ['cartItems' => [], 'total' => 0.00]);
        }

        // Obtener los items del carrito
        $cartItems = CartItem::where('carretilla_id', $cart->id)->with('product')->get();

        return view('dashboard', [
            'cartItems' => $cartItems,
            'total' => $cart->total,
        ]);
    }
}
