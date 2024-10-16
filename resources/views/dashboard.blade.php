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

        <!-- Botón para volver al inicio -->
        <a href="{{ route('home') }}" class="btn btn-primary">Volver al Inicio</a>
    </div>
@endsection
