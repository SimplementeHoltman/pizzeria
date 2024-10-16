@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->nombre }}</h1>
        <p>{{ $product->descripcion }}</p>
        <p><strong>Precio: </strong> Q{{ $product->precio }}</p>
        <p><strong>Stock disponible: </strong> {{ $product->stock }}</p>

        <!-- Mostrar la imagen del producto -->
        @if($product->imagen)
            <div>
                <img src="{{ asset('imagenes-productos/' . $product->imagen) }}" alt="{{ $product->nombre }}" style="width: 300px; height: auto;">
            </div>
        @endif

        <!-- Botón para agregar al carrito -->
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
        </form>

        <a href="{{ url()->previous() }}">Volver a la lista de productos</a>
    </div>
@endsection
