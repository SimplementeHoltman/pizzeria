@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
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

        <h1>Tu Carrito</h1>

        @if(isset($cartItems) && count($cartItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th class="hide-mobile">Precio Unitario</th>
                        <th class="hide-mobile">Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->nombre }}</td>
                            <td>
                                {{ $item->cantidad }}

                                <!-- Botón para aumentar la cantidad -->
                                <form action="{{ route('cart.increase', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">+</button>
                                </form>

                                <!-- Botón para disminuir la cantidad -->
                                <form action="{{ route('cart.decrease', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">—</button>
                                </form>
                            </td>
                            <td class="hide-mobile">Q{{ $item->precio_unitario }}</td>
                            <td class="hide-mobile">Q{{ $item->cantidad * $item->precio_unitario }}</td>
                            <td>
                                <!-- Botón para eliminar el producto -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total: </strong> Q{{ $total }}</p>
        @else
            <p>No hay productos en tu carrito.</p>
        @endif

        <!-- Selección de entrega -->
        <h2>Selecciona el método de entrega</h2>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="entrega" id="recogerSucursal" value="recoger">
            <label class="form-check-label" for="recogerSucursal">Recoger en Sucursal</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="entrega" id="aDomicilio" value="domicilio">
            <label class="form-check-label" for="aDomicilio">A Domicilio</label>
        </div>

        <!-- Mostrar sucursales -->
        <div id="sucursal-section" style="display:none;">
            <h2>Selecciona una sucursal</h2>
            <select id="branch-select" class="form-select">
                <option value="">Selecciona una sucursal</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->latitud }},{{ $branch->longitud }}">{{ $branch->nombre }}</option>
                @endforeach
            </select>

            <!-- Contenedor del mapa de sucursales -->
            <div id="map" style="height: 300px; width: 100%; margin-top: 20px;"></div>
        </div>

        <!-- Sección de direcciones guardadas y agregar nueva dirección -->
        <div id="domicilio-section" style="display:none;">
            <h2>Direcciones Guardadas</h2>
            @if(isset($addresses) && !$addresses->isEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Dirección</th>
                            <th class="hide-mobile">Ciudad</th>
                            <th class="hide-mobile">Código Postal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($addresses as $address)
                            <tr>
                                <td>
                                    <!-- Checkbox para seleccionar la dirección -->
                                    <input type="radio" class="address-radio" name="selected_address" value="{{ $address->latitud }},{{ $address->longitud }}">
                                </td>
                                <td>{{ $address->direccion }}</td>
                                <td class="hide-mobile">{{ $address->ciudad }}</td>
                                <td class="hide-mobile">{{ $address->codigo_postal }}</td>
                                <td>
                                    <!-- Formulario para eliminar la dirección -->
                                    <form action="{{ route('address.destroy', $address->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No tienes direcciones guardadas.</p>
            @endif
            <div id="map-address" style="height: 300px; width: 100%; margin-top: 20px;"></div>
            <!-- Formulario para agregar nueva dirección -->
            <h2>Agregar Dirección</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('address.store') }}" method="POST">
                @csrf
                <!-- Ocultar los campos de latitud y longitud -->
                <div class="mb-3" style="display:none;">
                    <label for="latitud" class="form-label">Latitud</label>
                    <input type="text" class="form-control" id="latitud" name="latitud" readonly>
                </div>

                <div class="mb-3" style="display:none;">
                    <label for="longitud" class="form-label">Longitud</label>
                    <input type="text" class="form-control" id="longitud" name="longitud" readonly>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>

                <div class="mb-3">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad">
                </div>

                <div class="mb-3">
                    <label for="codigo_postal" class="form-label">Código Postal</label>
                    <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                </div>

                <!-- Mapa para agregar la dirección -->
                <div id="map-add" style="height: 300px; width: 100%; margin-top: 20px;"></div>

                <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Guardar Dirección</button>
            </form>

            
        </div>

        <!-- Formulario de Pago -->
        <h2>Selecciona el método de pago</h2>
        <form action="{{ route('cart.payment') }}" method="POST">
            @csrf
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo_pago" id="pagoEfectivo" value="efectivo" required>
                <label class="form-check-label" for="pagoEfectivo">Pago en Efectivo (contra entrega)</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo_pago" id="pagoTarjeta" value="tarjeta" required>
                <label class="form-check-label" for="pagoTarjeta">Pago con Tarjeta</label>
            </div>

            <button type="submit" id="btnRealizarPago" class="btn btn-primary" style="margin-top: 20px;" disabled>Realizar Pago</button>
        </form>

        <h2>Carritos en Proceso</h2>
        @if($processingCarts->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th class="hide-general">ID</th>
                        <th class="hide-general">Usuario ID</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($processingCarts as $processingCart)
                        <tr>
                            <td class="hide-general">{{ $processingCart->id }}</td>
                            <td class="hide-general">{{ $processingCart->usuario_id }}</td>
                            <td>Q{{ $processingCart->total }}</td>
                            <td>
                                <form action="{{ route('cart.complete', $processingCart->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Marcar como Entregado</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay carritos en proceso.</p>
        @endif

        <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top: 20px;">Volver al Inicio</a>
    </div>

    <!-- Cargar Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMznw6Z7nd2ODWJv8WnYuE_MiAujSmLUc&callback=initMap" async defer></script>

    <script>
        // Inicializar el mapa de sucursales
        function initMap() {
            const initialLocation = { lat: {{ $branches->first()->latitud }}, lng: {{ $branches->first()->longitud }} };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: initialLocation,
            });

            let marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
            });

            document.getElementById('branch-select').addEventListener('change', function () {
                const coords = this.value.split(',');
                const newLatLng = { lat: parseFloat(coords[0]), lng: parseFloat(coords[1]) };

                marker.setPosition(newLatLng);
                map.setCenter(newLatLng);

                validateShipping();
            });
        }

        // Inicializar el mapa para agregar la dirección
        function initMapAdd() {
            const initialLocation = { lat: 14.634915, lng: -90.506882 }; // Coordenadas iniciales (Guatemala City)
            const mapAdd = new google.maps.Map(document.getElementById("map-add"), {
                zoom: 14,
                center: initialLocation,
            });

            let markerAdd = new google.maps.Marker({
                position: initialLocation,
                map: mapAdd,
            });

            // Al hacer clic en el mapa, mover el marcador a la nueva ubicación
            google.maps.event.addListener(mapAdd, 'click', function(event) {
                const clickedLocation = event.latLng;
                markerAdd.setPosition(clickedLocation);

                // Actualizar los valores de latitud y longitud en el formulario
                document.getElementById('latitud').value = clickedLocation.lat();
                document.getElementById('longitud').value = clickedLocation.lng();
            });
        }

        // Inicializar el mapa de direcciones guardadas
        function initMapAddress() {
            const mapAddress = new google.maps.Map(document.getElementById("map-address"), {
                zoom: 14,
                center: { lat: 14.634915, lng: -90.506882 },
            });

            let markerAddress = new google.maps.Marker({
                position: { lat: 14.634915, lng: -90.506882 },
                map: mapAddress,
            });

            // Cambiar el mapa y marcador cuando se seleccione una dirección
            document.querySelectorAll('.address-radio').forEach(radio => {
                radio.addEventListener('change', function () {
                    const coords = this.value.split(',');
                    const newLatLng = { lat: parseFloat(coords[0]), lng: parseFloat(coords[1]) };

                    markerAddress.setPosition(newLatLng);
                    mapAddress.setCenter(newLatLng);

                    validateShipping();
                });
            });
        }

        // Mostrar/ocultar secciones según la selección de método de entrega
        document.getElementById('recogerSucursal').addEventListener('change', function () {
            document.getElementById('sucursal-section').style.display = 'block';
            document.getElementById('domicilio-section').style.display = 'none';
            validateShipping();
        });

        document.getElementById('aDomicilio').addEventListener('change', function () {
            document.getElementById('sucursal-section').style.display = 'none';
            document.getElementById('domicilio-section').style.display = 'block';
            validateShipping();
        });

        // Validar que haya seleccionado una sucursal o una dirección
        function validateShipping() {
            const isBranchSelected = document.getElementById('recogerSucursal').checked && document.getElementById('branch-select').value !== "";
            const isAddressSelected = document.getElementById('aDomicilio').checked && document.querySelector('.address-radio:checked') !== null;

            const btnRealizarPago = document.getElementById('btnRealizarPago');
            if (isBranchSelected || isAddressSelected) {
                btnRealizarPago.disabled = false;
            } else {
                btnRealizarPago.disabled = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('nav-toggle');
            const navMenu = document.querySelector('.nav-menu');

            toggleButton.addEventListener('click', function() {
                navMenu.classList.toggle('active');
            });
        });

        // Inicializar todos los mapas al cargar la página
        window.addEventListener('load', function () {
            if (typeof initMap === 'function') {
                initMap();
            }
            if (typeof initMapAdd === 'function') {
                initMapAdd();
            }
            if (typeof initMapAddress === 'function') {
                initMapAddress();
            }
        });
    </script>
@endsection
