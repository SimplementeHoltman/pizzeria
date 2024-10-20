<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Branch; // Importamos el modelo Branch
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
            // Si ya está en el carrito, aumentar la cantidad si no supera el stock
            if ($cartItem->cantidad < $product->stock) {
                $cartItem->cantidad += 1;
                $cartItem->save();
                $cart->total += $product->precio;
                $cart->save();
            } else {
                return redirect()->route('dashboard')->with('error', 'No puedes agregar más de este producto, has alcanzado el stock.');
            }
        } else {
            // Si no está en el carrito, agregarlo
            CartItem::create([
                'carretilla_id' => $cart->id,
                'producto_id' => $product->id,
                'cantidad' => 1,
                'precio_unitario' => $product->precio,
            ]);

            $cart->total += $product->precio;
            $cart->save();
        }

        return redirect()->route('dashboard')->with('success', 'Producto agregado al carrito.');
    }

    // Método para aumentar la cantidad de un producto en el carrito
    public function increaseQuantity($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $product = Product::findOrFail($cartItem->producto_id);

        if ($cartItem->cantidad < $product->stock) {
            $cartItem->cantidad += 1;
            $cartItem->save();

            $cart = $cartItem->cart;
            $cart->total += $product->precio;
            $cart->save();
        }

        return redirect()->route('dashboard');
    }

    // Método para disminuir la cantidad de un producto en el carrito
    public function decreaseQuantity($id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->cantidad > 1) {
            $cartItem->cantidad -= 1;
            $cartItem->save();

            $cart = $cartItem->cart;
            $cart->total -= $cartItem->precio_unitario;
            $cart->save();
        }

        return redirect()->route('dashboard');
    }

    // Método para eliminar un producto del carrito
    public function removeItem($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cart = $cartItem->cart;

        // Restar el subtotal del producto al total del carrito
        $cart->total -= ($cartItem->cantidad * $cartItem->precio_unitario);
        $cart->save();

        // Eliminar el item del carrito
        $cartItem->delete();

        return redirect()->route('dashboard');
    }

    public function showCart()
    {
        // Obtener el carrito activo del usuario
        $cart = Cart::where('usuario_id', Auth::id())->where('estado', 'activo')->first();
    
        // Obtener los carritos en proceso
        $processingCarts = Cart::where('estado', 'procesando')->get();
    
        // Definir el total del carrito
        $total = $cart ? $cart->total : 0.00;
    
        // Obtener los items del carrito si el carrito existe
        $cartItems = $cart ? CartItem::where('carretilla_id', $cart->id)->get() : [];
    
        // Obtener todas las sucursales
        $branches = Branch::all();
    
        // Pasar las variables a la vista
        return view('dashboard', compact('cartItems', 'total', 'processingCarts', 'branches'));
    }
    
    
    
    
    public function processPayment(Request $request)
    {
        // Obtener el carrito activo del usuario
        $cart = Cart::where('usuario_id', Auth::id())->where('estado', 'activo')->first();
    
        if (!$cart) {
            return redirect()->route('dashboard')->with('error', 'No hay carritos activos.');
        }
    
        // Cambiar el estado del carrito a "procesando"
        $cart->estado = 'procesando';
        $cart->save();
    
        return redirect()->route('dashboard')->with('success', 'Pago realizado. Carrito en proceso.');
    }
    

    // Método para finalizar el carrito y eliminarlo
    public function completeCart($id)
    {
        $cart = Cart::findOrFail($id);

        // Eliminar el carrito y sus items
        $cart->cartItems()->delete();
        $cart->delete();

        return redirect()->route('dashboard')->with('success', 'Carrito finalizado y eliminado.');
    } 
}
