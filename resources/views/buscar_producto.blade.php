@extends('app')

@section('content')
<div class="container">
    <h1>Información del Producto</h1>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if (isset($producto))
    <div class="card-body">
    <div class="row">
        <div class="col">
            <h5>Lote del Producto: {{ $producto->lot_prod }}</h5>
        </div>
        <div class="col">
            <h5>Código del Producto: {{ $producto->code_prod }}</h5>
        </div>
        <div class="col">
            <h5>Nombre del Producto: {{ $producto->name_prod }}</h5>
        </div>
        @if ($producto->stock_prod > 0)
            <div class="col">
                <h5>Stock del Producto: {{ $producto->stock_prod }}</h5>
            </div>
        @endif
    </div>
</div>
<a href="{{ url('/') }}" class="btn btn-primary">Volver a Inicio</a>
    @if (count($despachos) > 0)
    <div class="card mt-4">
        <div class="card-header">
            Despachos con este Producto
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Número de Factura</th>
                        <th>Nombre del Conductor</th>
                        <th>Placa del Camión</th>
                        <th>Fecha del Despacho</th>
                        <th>Cliente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($despachos as $despacho)
                    <tr>
                        <td>{{ $despacho->bill_number_disp }}</td>
                        <td>{{ $despacho->driver_name_disp }}</td>
                        <td>{{ $despacho->truck_plate_disp }}</td>
                        <td>{{ $despacho->date_disp }}</td>
                        <td>{{ $despacho->client->name_cli }} ({{ $despacho->client->code_cli }})</td>
                        <td>
                            <a href="{{ route('despachos.detalle', $despacho) }}" class="btn btn-info">Ver Detalle</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-warning mt-4">
        No se encontraron despachos con este producto.
    </div>
    @endif
    @endif
</div>
@endsection