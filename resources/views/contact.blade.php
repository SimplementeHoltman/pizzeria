@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/contacto.css') }}">

@section('content')

    <nav class="nav-header">
        <div class="logo-title">
            <img src="{{ asset('logo.png') }}" alt="Logo de la Pizzería" class="logo">
            <h1 class="site-title">Pizzería Local</h1>
        </div>

        <button id="nav-toggle">☰ Menú</button> <!-- Botón del menú en móviles -->

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

    <div class="container">
        <h1>Contacto</h1>
        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
    <a href="{{ route('home') }}" class="back" style="margin-top: 20px;">Volver al Inicio</a>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('nav-toggle');
        const navMenu = document.querySelector('.nav-menu');

        toggleButton.addEventListener('click', function() {
            navMenu.classList.toggle('active'); // Alterna la clase 'active' para mostrar/ocultar el menú
        });
    });
</script>

@endsection
