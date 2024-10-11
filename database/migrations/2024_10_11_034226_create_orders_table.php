<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('carretilla_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('direccion_id')->constrained('addresses')->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['procesando', 'completado'])->default('procesando');
            $table->timestamps();
        });
    }
    
};
