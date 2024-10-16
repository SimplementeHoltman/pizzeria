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
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->nombre }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>Q{{ $item->precio_unitario }}</td>
                            <td>Q{{ $item->cantidad * $item->precio_unitario }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total: </strong> Q{{ $total }}</p>
        @else
            <p>No hay productos en tu carrito.</p>
        @endif
    </div>
@endsection
