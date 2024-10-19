@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tu Carrito</h1>

        @if(count($cartItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
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
                                    <button type="submit" class="btn btn-sm btn-warning">-</button>
                                </form>
                            </td>
                            <td>Q{{ $item->precio_unitario }}</td>
                            <td>Q{{ $item->cantidad * $item->precio_unitario }}</td>
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

        <!-- Mapa de Google Maps -->
        <h2>Selecciona una sucursal</h2>
        <select id="branch-select" class="form-select">
            @foreach($branches as $branch)
                <option value="{{ $branch->latitud }},{{ $branch->longitud }}">{{ $branch->nombre }}</option>
            @endforeach
        </select>

        <!-- Contenedor del mapa -->
        <div id="map" style="height: 300px; width: 50%; margin-top: 20px;"></div>

        <!-- Botón para volver al inicio -->
        <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top: 20px;">Volver al Inicio</a>
    </div>

    <!-- Cargar Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMznw6Z7nd2ODWJv8WnYuE_MiAujSmLUc&callback=initMap" async defer></script>

    <script>
        // Función para inicializar el mapa
        function initMap() {
            // Coordenadas iniciales
            const initialLocation = { lat: {{ $branches->first()->latitud }}, lng: {{ $branches->first()->longitud }} };

            // Crear el mapa
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: initialLocation,
            });

            // Crear un marcador para la ubicación inicial
            let marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
            });

            // Actualizar el marcador cuando se seleccione otra sucursal
            document.getElementById('branch-select').addEventListener('change', function () {
                const coords = this.value.split(',');
                const newLatLng = { lat: parseFloat(coords[0]), lng: parseFloat(coords[1]) };

                // Mover el marcador a la nueva ubicación
                marker.setPosition(newLatLng);
                map.setCenter(newLatLng);
            });
        }

        // Forzar la recarga del mapa al cargar la página completamente
        window.addEventListener('load', function () {
            if (typeof initMap === 'function') {
                initMap();
            }
        });
    </script>
@endsection
