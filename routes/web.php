<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::resource('productos', ProductController::class);
Route::put('productos/descontinue/{producto}', [ProductController::class, 'descontinue'])->name('productos.descontinue');
Route::get('productos/descontinuados', [ProductController::class, 'discontinued'])->name('productos.descontinuados');
Route::resource('clientes', ClientController::class);
Route::get('despachos/historial', [DispatchController::class, 'listarDespachos'])->name('despachos.historial');
Route::resource('despachos', DispatchController::class);
Route::get('despachos/{despacho}', [DispatchController::class, 'mostrarDetalle'])->name('despachos.detalle');
Route::match(['get', 'post'], 'productos/buscar', [ProductController::class, 'buscarProducto'])->name('producto.buscar');
Route::resource('suplies',SupplieController::class);