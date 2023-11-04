@extends('app')

@section('content')
<div class="container">
    <h1>Gestión de Productos</h1>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('producto.buscar') }}" method="post" class="form-inline">
        @csrf
        <div class="input-group">
            <input class="form-control" required type="text" id="txt_lote" name="txt_lote" placeholder="Número de Lote">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Buscar Producto</button>
            </div>
        </div>
    </form>

    <div class="row mt-3">
        <div class="col-md-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIngresarProducto">1. Ingresar Producto</button>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIngresarCliente">2. Ingresar Cliente</button>
        </div>
        <div class="col-md-3">
            <a href="{{ route('despachos.index') }}" class="btn btn-primary">3. Despachar Producto</a>
        </div>
        <div class="col-md-3">
             <button class="btn btn-primary"data-bs-toggle="modal" data-bs-target="#modalIngresarMateriaPrima">4. Ingresar Materia Prima</button>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <a class="btn btn-primary" href="{{ route('productos.index') }}">1. Inventario</a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-primary" href="{{ route('clientes.index') }}">2. Lista de clientes</a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-primary" href="{{ route('despachos.historial') }}">3. Historial de Despachos</a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-primary" href="{{ route('suplies.index') }}">4. Inventario materias primas</a>
        </div>
    </div>
</div>

<!-- Modal para Ingresar Producto -->
<div class="modal fade" id="modalIngresarProducto" tabindex="-1" role="dialog" aria-labelledby="modalLabelIngresarProducto" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelIngresarProducto">Ingresar Producto</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('productos.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Número de Lote:</label>
                        <input type="text" class="form-control" required id="txt_lote_producto" name="txt_lote_producto">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código de Producto:</label>
                        <input type="text" class="form-control" required id="txt_codigo_producto" name="txt_codigo_producto">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto:</label>
                        <input type="text" class="form-control" required id="txt_nombre_producto" name="txt_nombre_producto">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock del Producto:</label>
                        <input type="number" class="form-control" required min="1" step="1" id="txt_stock_producto" name="txt_stock_producto">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ingresar Cliente -->
<div class="modal fade" id="modalIngresarCliente" tabindex="-1" role="dialog" aria-labelledby="modalLabelIngresarCliente" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelIngresarCliente">Ingresar Cliente</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('clientes.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre del Cliente:</label>
                        <input type="text" class="form-control" required id="txt_nombre_cliente" name="txt_nombre_cliente">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código del Cliente:</label>
                        <input type="text" class="form-control" required id="txt_codigo_cliente" name="txt_codigo_cliente">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Modal para Ingresar Materia Prima -->
<div class="modal fade" id="modalIngresarMateriaPrima" tabindex="-1" role="dialog" aria-labelledby="modalLabelIngresarMateriaPrima" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelIngresarMateriaPrima">Ingresar Materia Prima</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('suplies.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Código de Materia Prima:</label>
                        <input type="text" class="form-control" required id="txt_codigo_materia" name="txt_codigo_materia">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de Materia Prima:</label>
                        <input type="text" class="form-control" required id="txt_nombre_materia" name="txt_nombre_materia">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock de Materia Prima:</label>
                        <input type="number" class="form-control" required min="1" step="1" id="txt_stock_materia" name="txt_stock_materia">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Materia Prima</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection