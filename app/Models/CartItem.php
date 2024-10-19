<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Definir los campos que se pueden rellenar de forma masiva (mass assignable)
    protected $fillable = [
        'carretilla_id',  // Asegúrate de que esta columna esté en la base de datos
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    // Definir la relación con el carrito (Cart)
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'carretilla_id');
    }

    // Definir la relación con el producto (Product)
    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}
