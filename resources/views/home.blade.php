@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

@section('content')
    <div class="container">
        <!-- Menú de navegación -->
        <nav class="nav-header">
            <!-- Sección del logo y título -->
            <div class="logo-title">
                <img src="{{ asset('logo.png') }}" alt="Logo de la Pizzería" class="logo">
                <h1 class="site-title">Pizzería Local</h1>
            </div>

            <!-- Botón de menú para móviles -->
            <button id="nav-toggle">☰ Menú</button>

            <!-- Barra de navegación -->
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

        <!-- Mostrar categorías y productos -->
        @foreach ($categories as $category)
            <div class="category">
                <h3>{{ $category->nombre }}</h3>
                <p>{{ $category->descripcion }}</p>

                <h4>Productos:</h4>
                <div class="products-grid">
                    @foreach ($category->products as $product)
                        <!-- Hacer toda la tarjeta clickeable -->
                        <a href="{{ route('productos.show', $product->id) }}" class="product-link">
                            <div class="product-item">
                                <h4>{{ $product->nombre }}</h4>

                                <!-- Mostrar la imagen del producto -->
                                @if($product->imagen)
                                    <img src="{{ asset('imagenes-productos/' . $product->imagen) }}" alt="{{ $product->nombre }}">
                                @endif

                                <!-- Mostrar el precio con estilo especial -->
                                <div class="product-price">
                                    Q{{ $product->precio }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

    <!-- Aquí incluimos el JavaScript al final del archivo -->
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
