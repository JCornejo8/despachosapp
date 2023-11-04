@extends('app')

@section('content')
<div class="container">
    <h1>Detalles del Despacho</h1>

    <p><strong>Número de Factura:</strong> {{ $despacho->bill_number_disp }}</p>

    <h2>Detalle</h2>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Número de Lote</th>
                <th>Código de Producto</th>
                <th>Nombre del Producto</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detallesDespacho as $detalle)
                <tr>
                    <td>{{ $detalle->product->lot_prod }}</td>
                    <td>{{ $detalle->product->code_prod }}</td>
                    <td>{{ $detalle->product->name_prod }}</td>
                    <td>{{ $detalle->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('despachos.historial') }}" class="btn btn-primary">Volver al Historial</a>
</div>
@endsection