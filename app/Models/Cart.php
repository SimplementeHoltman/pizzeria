<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'estado', 'total'];

    // Relación: un carrito tiene muchos productos (items)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'carretilla_id');
    }
}
