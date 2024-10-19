<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'latitud',
        'longitud',
        'direccion',
        'ciudad',
        'codigo_postal'
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
