@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/producto.css') }}">

@section('content')
    <div class="container">
        <!-- Menú de navegación -->
        <nav class="nav-header">
            <div class="logo-title">
                <img src="{{ asset('logo.png') }}" alt="Logo de la Pizzería" class="logo">
                <h1 class="site-title">Pizzería Local</h1>
            </div>

            <button id="nav-toggle">☰ Menú</button>

            <div class="nav-menu">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('about') }}">Sobre Nosotros</a>
                <a href="{{ route('contact') }}">Contacto</a>
                @if (Auth::check())
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Registro</a>
                @endif
            </div>
        </nav>

        <!-- Sección de detalles del producto -->
        <div class="product-details">
            <div class="product-info">
                <h1>{{ $product->nombre }}</h1>
                <p>{{ $product->descripcion }}</p>
                <p><strong>Precio: </strong> Q{{ $product->precio }}</p>
                <p><strong>Stock disponible: </strong> {{ $product->stock }}</p>

                <!-- Botón para agregar al carrito -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
                </form>

                <!-- Volver a la lista de productos -->
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver a la lista de productos</a>
            </div>

            <!-- Mostrar la imagen del producto -->
            @if($product->imagen)
                <div class="product-image">
                    <img src="{{ asset('imagenes-productos/' . $product->imagen) }}" alt="{{ $product->nombre }}">
                </div>
            @endif
        </div>
    </div>

    <!-- Script para el menú en móviles -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('nav-toggle');
            const navMenu = document.querySelector('.nav-menu');

            toggleButton.addEventListener('click', function() {
                navMenu.classList.toggle('active');
            });
        });
    </script>
@endsection
