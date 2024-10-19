<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    // Definir los campos que se pueden rellenar de forma masiva (mass assignable)
    protected $fillable = ['nombre', 'direccion', 'latitud', 'longitud'];
}
