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
                    <!-- Mostrar Dashboard y Logout si el usuario está autenticado -->
                    <a href="{{ route('dashboard') }}">Dashboard</a> |
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <!-- Mostrar Login y Registro si el usuario no está autenticado -->
                    <a href="{{ route('login') }}">Login</a> |
                    <a href="{{ route('register') }}">Registro</a>
                @endif
            </div>

        </nav>

        <!-- Mostrar categorías -->
        <h2>Categorías</h2>
        <ul>
            @foreach ($categories as $category)
                <li>{{ $category->nombre }}</li>
            @endforeach
        </ul>

        <!-- Mostrar productos -->
        <h2>Productos</h2>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->nombre }}</h5>
                            <p class="card-text">{{ $product->descripcion }}</p>
                            <p class="card-text">Precio: Q{{ $product->precio }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
