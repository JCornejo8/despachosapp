@extends('app')

@section('content')
<div class="container">
    <h1>Registrar Despacho</h1>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver a Inicio</a>
    <form method="post" action="{{ route('despachos.store') }}">
        @csrf

        <div class="form-group">
            <label for="cliente_id">Seleccionar Cliente</label>
            <select class="form-control" name="cliente_id" id="cliente_id">
                @foreach ($clients as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->name_cli }} (COD: {{ $cliente->code_cli }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="txt_bill">Número de Factura</label>
            <input type="number" required class="form-control" name="txt_bill" id="txt_bill">
        </div>

        <div class="form-group">
            <label for="txt_driver_name">Nombre del Conductor</label>
            <input type="text" required class="form-control" name="txt_driver_name" id="txt_driver_name" pattern="^[A-Za-z\s]+$" title="Ingrese un nombre válido sin números ni caracteres especiales">
        </div>

        <div class="form-group">
            <label for="txt_truck_plate">Patente del Camión</label>
            <input type="text" required  class="form-control" name="txt_truck_plate" id="txt_truck_plate">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="num_lote" style="margin-right: 10px;"> Nro. de Lote </label>
            <input type="text" class="form-control" name="num_lote" id="num_lote" style="margin-right: 10px;">
            <!-- Combobox de productos con opción por defecto -->
            <select required  class="form-control" name="producto_id" id="producto_id">
                <option value="">Nombre del Producto</option> <!-- Opción por defecto -->
                @foreach ($products as $producto)
                <option value="{{ $producto->id }}" required  data-lot="{{ $producto->lot_prod }}" data-stock="{{ $producto->stock_prod }}">{{ $producto->name_prod }}</option>
                @endforeach
            </select>
            <!-- Mostrar stock del producto seleccionado -->
            <span id="stockProducto" style="margin-left: 10px;"></span>
        </div>

        <button type="button" class="btn btn-success" id="agregarProducto">+</button>
        <button type="button" class="btn btn-danger" id="quitarProducto">-</button>

        <!-- Tabla para mostrar los productos seleccionados -->
        <table class="table" id="productosTable">
            <thead>
                <tr>
                    <th>Nro. Lote</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody id="productosSeleccionados">
                <!-- Aquí se agregarán los productos seleccionados -->
            </tbody>
        </table>
        <input type="hidden" name="datos_despacho" id="datos_despacho" value="">
        <button type="submit" class="btn btn-primary">Registrar Despacho</button>
    </form>
</div>

<script>
    // Código JavaScript para buscar productos por número de lote
    $('#num_lote').on('input', function() {
        var selectedProduct = $('#producto_id').find('option[data-lot="' + $(this).val() + '"]');
        if (selectedProduct.length > 0) {
            $('#producto_id').val(selectedProduct.val());
            mostrarStockProducto(selectedProduct.data('stock'));
        } else {
            $('#producto_id').val('');
            mostrarStockProducto('Producto no registrado o descontinuado');
        }
    });
    // Código JavaScript para sincronizar el campo de texto con el combobox
    $('#producto_id').on('change', function() {
        var selectedProduct = $('#producto_id option:selected');
        var numLote = selectedProduct.data('lot');
        $('#num_lote').val(numLote);
        mostrarStockProducto(selectedProduct.data('stock'));
    });

    function mostrarStockProducto(stock) {
        $('#stockProducto').text('Stock: ' + stock);
    }

    // Código JavaScript para agregar y quitar productos de la tabla
    $('#agregarProducto').on('click', function() {
        var productoId = $('#producto_id').val();
        var productoNombre = $('#producto_id option:selected').text();
        var cantidadActual = parseInt($('#productosSeleccionados').find('tr[data-id="' + productoId + '"] .cantidad').text()) || 0;
        var stock = parseInt($('#producto_id option:selected').data('stock'));

        console.log('productoId:', productoId);
        console.log('productoNombre:', productoNombre);
        console.log('cantidadActual:', cantidadActual);
        console.log('stock:', stock);

        if (productoId) {
            if (cantidadActual < stock) {
                cantidadActual += 1;

                if ($('#productosSeleccionados').find('tr[data-id="' + productoId + '"]').length) {
                    $('#productosSeleccionados').find('tr[data-id="' + productoId + '"] .cantidad').text(cantidadActual);
                } else {
                    $('#productosSeleccionados').append('<tr data-id="' + productoId + '"><td>' + $('#num_lote').val() + '</td><td>' + productoNombre + '</td><td class="cantidad">' + cantidadActual + '</td></tr>');
                }

                // Actualiza el campo oculto con los datos de la tabla
                actualizarCampoOculto();
            } else {
                alert('No puedes agregar más productos de este tipo, ya que excede el stock.');
            }

            // Limpia el campo de cantidad
            $('#cantidad').val(1);
        }
    });

    $('#quitarProducto').on('click', function() {
        var productoId = $('#producto_id').val();
        var cantidadActual = parseInt($('#productosSeleccionados').find('tr[data-id="' + productoId + '"] .cantidad').text()) || 0;

        if (productoId) {
            if (cantidadActual > 1) {
                cantidadActual -= 1;
                $('#productosSeleccionados').find('tr[data-id="' + productoId + '"] .cantidad').text(cantidadActual);
            } else {
                $('#productosSeleccionados').find('tr[data-id="' + productoId + '"]').remove();
            }

            // Actualiza el campo oculto con los datos de la tabla
            actualizarCampoOculto();
        }
    });

    function actualizarCampoOculto() {
        var datosDespacho = [];

        // Recopila los datos de las filas
        $('#productosSeleccionados tr').each(function () {
            var numeroLote = $(this).find('td:nth-child(1)').text(); // Obtiene el número de lote como cadena
            var cantidad = parseInt($(this).find('td.cantidad').text());

            // Agrega "numeroLote,cantidad" para cada producto
            datosDespacho.push(numeroLote + ',' + cantidad);
        });

        // Combina los datos en un formato específico
        var datosComprimidos = datosDespacho.join('|')+"|";

        // Actualiza el campo oculto con los datos comprimidos
        $('#datos_despacho').val(datosComprimidos);
    }

</script>
</div>
@endsection