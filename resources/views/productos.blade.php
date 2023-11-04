@extends('app')

@section('content')
<div class="container">
    <h1>Inventario de productos</h1>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Productos Disponibles</h2>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Número de Lote</th>
                                <th>Código de Producto</th>
                                <th>Nombre del Producto</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->lot_prod }}</td>
                                <td>{{ $producto->code_prod }}</td>
                                <td>{{ $producto->name_prod }}</td>
                                <td>{{ $producto->stock_prod }}</td>
                                <td>
                                    <form method="POST" action="{{ route('productos.descontinue', $producto->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que desea descontinuar el producto {{ $producto->name_prod }}?')">Descontinuar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Productos Descontinuados</h2>
                </div>
                <div class="panel-body">
                    @if (count($discontinuedProducts) > 0)
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Número de Lote</th>
                                    <th>Código de Producto</th>
                                    <th>Nombre del Producto</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($discontinuedProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->lot_prod }}</td>
                                    <td>{{ $product->code_prod }}</td>
                                    <td>{{ $product->name_prod }}</td>
                                    <td>{{ $product->stock_prod }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay productos descontinuados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection