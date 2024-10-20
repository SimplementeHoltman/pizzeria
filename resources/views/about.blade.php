@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/about.css') }}">

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
    <h1>Sobre Nosotros</h1>
		<p>
			<strong>Pizzería Local</strong> es una pizzería de tradición que se ha ganado el cariño y la lealtad de nuestros clientes al ofrecer deliciosas pizzas artesanales elaboradas con ingredientes frescos y de la más alta calidad. Desde nuestros inicios, nuestro objetivo ha sido brindar una experiencia gastronómica excepcional, destacándonos por nuestro compromiso con la autenticidad y el sabor en cada una de nuestras recetas.
		</p>

		<h2>Nuestra Filosofía</h2>
		<p>
			En <strong>Pizzería Local</strong>, creemos que una buena pizza debe ser algo más que una simple comida; debe ser una celebración del arte culinario italiano, fusionada con los sabores locales que nos representan. Cada pizza que sale de nuestro horno es el resultado de años de perfección y pasión por el buen comer. Nos esforzamos en seleccionar cuidadosamente los ingredientes, desde nuestras harinas especiales para una masa perfecta, hasta los mejores tomates, quesos y embutidos que dan vida a nuestras recetas.
		</p>

		<h2>Nuestra Oferta</h2>
		<p>
			Contamos con una amplia variedad de pizzas para satisfacer todos los gustos:
		</p>
		<ul>
			<li><strong>Pizzas Clásicas</strong>: Las favoritas de siempre, como la Margarita, Pepperoni y Cuatro Quesos, elaboradas respetando las recetas tradicionales.</li>
			<li><strong>Pizzas Gourmet</strong>: Innovamos con combinaciones únicas que despiertan los sentidos, como nuestra pizza con prosciutto y rúcula, o nuestra pizza vegetariana con ingredientes frescos de temporada.</li>
			<li><strong>Pizzas Personalizadas</strong>: En <strong>Pizzería Local</strong>, los clientes pueden crear su propia pizza seleccionando de una amplia gama de ingredientes, para disfrutar de una pizza completamente a su gusto.</li>
		</ul>
		<p>
			Además, ofrecemos <strong>calzones, pastas frescas, ensaladas y una variedad de postres</strong> caseros que complementan a la perfección nuestro menú.
		</p>

		<h2>Compromiso con la Calidad</h2>
		<p>
			Nos enorgullece mantener altos estándares de calidad en todo lo que hacemos. Desde la selección de los ingredientes hasta el servicio en nuestras mesas, nuestro equipo se dedica a asegurarse de que cada visita a <strong>Pizzería Local</strong> sea una experiencia memorable. También ofrecemos opciones para clientes con dietas especiales, como pizzas sin gluten o opciones veganas.
		</p>

		<h2>Ambiente Acogedor</h2>
		<p>
			En <strong>Pizzería Local</strong>, queremos que nuestros clientes se sientan como en casa. Nuestro restaurante combina un ambiente cálido y acogedor, ideal tanto para disfrutar de una comida con amigos y familiares, como para una cena íntima. Cada rincón de nuestro local está diseñado para proporcionar una experiencia cómoda y placentera, complementada por un servicio al cliente excepcional que siempre está atento a las necesidades de nuestros visitantes.
		</p>

		<h2>Delivery y Servicio a Domicilio</h2>
		<p>
			Sabemos que a veces el mejor lugar para disfrutar una pizza es en la comodidad del hogar. Por ello, ofrecemos un servicio de entrega rápida para que nuestros clientes puedan disfrutar de nuestras pizzas frescas y calientes sin tener que salir de casa. A través de nuestra plataforma en línea o por teléfono, es posible realizar pedidos personalizados y seleccionar el método de entrega más conveniente.
		</p>

		<h2>Compromiso con la Comunidad</h2>
		<p>
			Estamos comprometidos no solo con ofrecer la mejor pizza, sino también con contribuir al bienestar de nuestra comunidad. Apoyamos a proveedores locales y participamos activamente en iniciativas comunitarias, ofreciendo nuestra ayuda y recursos para diversas causas solidarias y eventos locales.
		</p>

		<p>
			<strong>Pizzería Local</strong> no es solo un lugar para disfrutar de una pizza; es una experiencia completa donde la calidad, el sabor y el servicio se combinan para crear momentos inolvidables. ¡Te invitamos a visitarnos y a probar nuestras pizzas hechas con amor y dedicación!
		</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top: 20px;">Volver al Inicio</a>


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
