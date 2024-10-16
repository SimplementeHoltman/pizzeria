@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->nombre }}</h1>
        <p>{{ $product->descripcion }}</p>
        <p><strong>Precio: </strong> Q{{ $product->precio }}</p>
        <p><strong>Stock disponible: </strong> {{ $product->stock }}</p>
        <a href="{{ url()->previous() }}">Volver a la lista de productos</a>
    </div>
@endsection
