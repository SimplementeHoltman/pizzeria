@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tu Carrito</h1>

        @if(isset($cartItems) && count($cartItems) > 0)
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

        <!-- Mostrar sucursales -->
        <h2>Selecciona una sucursal</h2>
        <select id="branch-select" class="form-select">
            @foreach($branches as $branch)
                <option value="{{ $branch->latitud }},{{ $branch->longitud }}">{{ $branch->nombre }}</option>
            @endforeach
        </select>

        <!-- Contenedor del mapa de sucursales -->
        <div id="map" style="height: 300px; width: 50%; margin-top: 20px;"></div>

        <!-- Formulario para agregar nueva dirección -->
        <h2>Agregar Dirección</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('address.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="latitud" class="form-label">Latitud</label>
                <input type="text" class="form-control" id="latitud" name="latitud" readonly>
            </div>

            <div class="mb-3">
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

        <h2>Direcciones Guardadas</h2>
        @if(isset($addresses) && !$addresses->isEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Código Postal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addresses as $address)
                        <tr>
                            <td>
                                <!-- Checkbox para seleccionar la dirección -->
                                <input type="checkbox" class="address-checkbox" value="{{ $address->latitud }},{{ $address->longitud }}">
                            </td>
                            <td>{{ $address->direccion }}</td>
                            <td>{{ $address->ciudad }}</td>
                            <td>{{ $address->codigo_postal }}</td>
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

            // Cambiar el mapa y marcador cuando se seleccione una dirección, solo permitir una selección a la vez
            document.querySelectorAll('.address-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    // Deseleccionar todos los otros checkboxes
                    document.querySelectorAll('.address-checkbox').forEach(box => {
                        if (box !== checkbox) {
                            box.checked = false;
                        }
                    });

                    // Si se selecciona un checkbox, actualizar el mapa
                    if (this.checked) {
                        const coords = this.value.split(',');
                        const newLatLng = { lat: parseFloat(coords[0]), lng: parseFloat(coords[1]) };
                        
                        markerAddress.setPosition(newLatLng);
                        mapAddress.setCenter(newLatLng);
                    }
                });
            });
        }
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
