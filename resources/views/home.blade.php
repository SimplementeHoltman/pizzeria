@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Menú de navegación -->
        <nav>
            <a href="{{ route('home') }}">Inicio</a> |
            <a href="{{ route('categories') }}">Categorías</a> |
            <a href="{{ route('about') }}">Sobre Nosotros</a> |
            <a href="{{ route('contact') }}">Contacto</a>
            <div class="float-right">
                @if (Auth::check())
                    <a href="{{ route('dashboard') }}">Dashboard</a> |
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a> |
                    <a href="{{ route('register') }}">Registro</a>
                @endif
            </div>
        </nav>

        <!-- Mostrar categorías y productos -->
        <h2>Categorías y Productos</h2>

        @foreach ($categories as $category)
            <div class="category">
                <h3>{{ $category->nombre }}</h3>
                <p>{{ $category->descripcion }}</p>

                <h4>Productos:</h4>
                <ul>
                    @foreach ($category->products as $product)
                        <li>
                            <a href="{{ route('productos.show', $product->id) }}">
                                <strong>{{ $product->nombre }}</strong>
                            </a>
                            Q{{ $product->precio }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@endsection
