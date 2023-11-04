@extends('app')
@section('content')
<div class="container">
    <h1>Historial de Despachos</h1>

    <a href="{{ url('/') }}" class="btn btn-primary">Volver a Inicio</a>
    <form method="get" action="" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" name="num_factura" id="num_factura" placeholder="Número de Factura">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </div>
    </form>

    <div class="panel panel-default">
        <div class="panel-body">
            <table id="tablaDespachos" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Número de Factura</th>
                        <th>Cliente</th>
                        <th>Nombre del Conductor</th>
                        <th>Placa del Camión</th>
                        <th>Fecha del Despacho</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($despachos as $despacho)
                    <tr>
                        <td>{{ $despacho->bill_number_disp }}</td>
                        <td>{{ 'COD (' . $despacho->client->code_cli . ') - ' . $despacho->client->name_cli }}</td>
                        <td>{{ $despacho->driver_name_disp }}</td>
                        <td>{{ $despacho->truck_plate_disp }}</td>
                        <td>{{ $despacho->date_disp }}</td>
                        <td>
                            <a href="{{ route('despachos.detalle', $despacho) }}" class="btn btn-info">Ver Detalle</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
    // Obtén una referencia al campo de búsqueda
    const numFacturaInput = document.getElementById('num_factura');

    // Obtén una referencia a la tabla y a todas las filas
    const table = document.getElementById('tablaDespachos');
    const rows = table.querySelectorAll('tbody tr');

    // Agrega un event listener para escuchar cambios en el campo de búsqueda
    numFacturaInput.addEventListener('input', function () {
        const numFactura = this.value.toLowerCase();

        rows.forEach(row => {
            const facturaCell = row.cells[0].textContent.toLowerCase(); // Asegúrate de que corresponda a la columna adecuada
            if (facturaCell.includes(numFactura)) {
                row.style.display = ''; // Muestra la fila si coincide
            } else {
                row.style.display = 'none'; // Oculta la fila si no coincide
            }
        });
    }); 
</script>
</div>
@endsection

