<?php

namespace App\Http\Controllers;

use App\Models\Dispatch;
use App\Models\DispatchDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Product::where('stock_prod', '>', 0)->get();
        $discontinuedProducts = Product::where('stock_prod', 0)->get(); // Productos descontinuados


        return view('productos', compact('productos', 'discontinuedProducts'));
    }
    public function descontinue(Product $producto)
    {
       
        $producto->stock_prod = 0;
        $producto->save();
    
        return redirect()->route('productos.index')->with('success', 'Producto descontinuado correctamente');
    }

    public function buscarProducto(Request $request)
    {
        $numeroLote = $request->input('txt_lote');

        // Realiza la búsqueda del producto
        $producto = Product::where('lot_prod', $numeroLote)->first();
    
        if (!$producto) {
            return redirect()->route('productos.index')->with('error', 'El número de lote no se encontró en los productos registrados.');
        }
    
        $detalles_coincidentes = DispatchDetail::where('product_id', $producto->id)->get();
        
        $despachos_id = $detalles_coincidentes->pluck('dispatch_id')->unique();    
        $despachos = Dispatch::whereIn('id', $despachos_id)->get();
       // dd($despachos);
        return view('buscar_producto', compact('producto', 'despachos'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'txt_lote_producto' => 'required|string',
            'txt_codigo_producto' => 'required|string',
            'txt_nombre_producto' => 'required|string',
            'txt_stock_producto' => 'required|integer|min:1', // Agregar esta regla para validar stock mayor o igual a 1
        ]);
    
        // Verifica si el lote (lot_prod) ya existe en la base de datos
        $existingProduct = Product::where('lot_prod', $request->input('txt_lote_producto'))->first();
    
        if ($existingProduct) {
            return redirect('/')->with('error', 'Ya existe un lote ingresado con ese numero')->withInput();
            
        
        }    
        // Si el lote no existe y el stock cumple con la condición, crea un nuevo producto
        $product = new Product;
        $product->lot_prod = $request->input('txt_lote_producto');
        $product->code_prod = $request->input('txt_codigo_producto');
        $product->name_prod = $request->input('txt_nombre_producto');
        $product->stock_prod = $request->input('txt_stock_producto');
        
        // Guarda el producto en la base de datos
        $product->save();
    
        return redirect('/')->with('success', 'Producto ingresado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
