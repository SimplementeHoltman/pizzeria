<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['carretilla_id', 'producto_id', 'cantidad', 'precio_unitario'];

    // Relación: cada item del carrito pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    // Relación: cada item pertenece a un carrito
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'carretilla_id');
    }
}
