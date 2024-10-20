<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Branch;
use App\Models\CartItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        // Obtener las direcciones del usuario autenticado
        $addresses = Address::where('usuario_id', Auth::id())->get();
        
        // Obtener las sucursales
        $branches = Branch::all();
        
        // Obtener el carrito activo del usuario
        $cart = Cart::where('usuario_id', Auth::id())->where('estado', 'activo')->first();
        
        // Definir el total del carrito
        $total = $cart ? $cart->total : 0.00;
        
        // Obtener los items del carrito
        $cartItems = $cart ? CartItem::where('carretilla_id', $cart->id)->get() : [];
        
        // Obtener los carritos en estado 'procesando' pero solo del usuario autenticado
        $processingCarts = Cart::where('estado', 'procesando')->where('usuario_id', Auth::id())->get();
    
        // Pasar todas las variables necesarias a la vista
        return view('dashboard', compact('branches', 'cartItems', 'addresses', 'total', 'processingCarts'));
    }
    
    // Método para guardar una nueva dirección
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:20',
        ]);

        // Crear una nueva dirección en la base de datos
        Address::create([
            'usuario_id' => Auth::id(),  // Asociar la dirección al usuario autenticado
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'codigo_postal' => $request->codigo_postal,
        ]);

        // Redirigir de vuelta al dashboard con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Dirección guardada correctamente.');
    }
    
    public function destroy($id)
    {
        // Encontrar la dirección por su ID y asegurarse de que pertenece al usuario autenticado
        $address = Address::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();
        
        // Eliminar la dirección
        $address->delete();
        
        // Redirigir al dashboard con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Dirección eliminada correctamente.');
    }
    
    
}
