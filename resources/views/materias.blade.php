@extends('app')

@section('content')
<div class="container">
    <h1>Lista de Materias Primas</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ url('/') }}" class="btn btn-primary">Volver a Inicio</a>

    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplies as $supplie)
            <tr>
                <td>{{ $supplie->code_sup }}</td>
                <td>{{ $supplie->name_sup }}</td>
                <td>{{ $supplie->stock_sup }}</td>
                <td>
                    <form action="{{ route('suplies.update', $supplie->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="input-group">
                            <input type="number" name="stock_change" class="form-control" placeholder="Cantidad"  min="1" step="1" required>
                            <div class="input-group-append">
                                <button type="submit" name="action" value="increase" class="btn btn-success">Aumentar</button>
                                <button type="submit" name="action" value="decrease" class="btn btn-danger">Disminuir</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection