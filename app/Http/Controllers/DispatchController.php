<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dispatch;
use App\Models\DispatchDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        $products = Product::where('stock_prod', '>', 0)->get();

        

        return view('despachos', compact('clients', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           // Obtén la lista de clientes y productos disponibles con stock mayor a 0
           $clientes = Client::all();
           $productosDisponibles = Product::where('stock_prod', '>', 0)->get();
   
           return view('despachos.create', compact('clientes', 'productosDisponibles'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente_id = $request->input('cliente_id');
        $numero_factura = $request->input('txt_bill');
        $nombre_conductor = $request->input('txt_driver_name');
        $patente_camion = $request->input('txt_truck_plate');
        $datos_despacho = $request->input('datos_despacho');

        $dispatch = new Dispatch();
        $dispatch->bill_number_disp = $numero_factura;
        $dispatch->driver_name_disp = $nombre_conductor;
        $dispatch->truck_plate_disp = $patente_camion;
        $dispatch->date_disp = now();
        $dispatch->client_id = $cliente_id; // Asigna el cliente al despacho
        $dispatch->save(); // Guarda el despacho      

        $ultimoDespacho = Dispatch::latest('id')->first(); // Obtiene el ID del último despacho creado
        $datos_despacho = rtrim($datos_despacho, '|'); // Elimina el último '|' si existe
        $elementos = explode('|', $datos_despacho); // Divide los elementos por '|'
        foreach ($elementos as $elemento) {
            $detalle = explode(',', $elemento); // Divide cada elemento por ','
            if (count($detalle) == 2) {
                $numero_lote = $detalle[0];
                $cantidad = $detalle[1];               
                // Aquí deberías buscar el ID del producto en función del número de lote y luego guardar el detalle en la base de datos
                // Te proporcionaré un ejemplo de cómo buscar el ID del producto
                $producto = Product::where('lot_prod', $numero_lote)->first();
                if ($producto) {
                    // Ahora puedes guardar el detalle en la base de datos
                    $detalleDespacho = new DispatchDetail();
                    $detalleDespacho->dispatch_id = $ultimoDespacho->id;
                    $detalleDespacho->product_id = $producto->id;
                    $detalleDespacho->quantity = $cantidad;
                    $detalleDespacho->save();
                    
                    $producto->stock_prod -= $cantidad;
                    $producto->save();
                    return redirect('/')->with('success', 'Despacho ingresado correctamente');

                } else {
                    return redirect('/')->with('error', 'algo salío mal');
                }
            }return redirect('/')->with('error', 'Creado despacho con carrito vacio ');
        }
    }
    public function listarDespachos()
    {
        $despachos = Dispatch::with('client')->orderBy('date_disp', 'desc')->get();  
        //dd($despachos);
        return view('lista_despachos', compact('despachos'));
    }
    public function mostrarDetalle($id)
    {
        // Obtener el despacho por su ID
        $despacho = Dispatch::findOrFail($id);
    
        // Obtener los detalles del despacho
        $detallesDespacho = DispatchDetail::where('dispatch_id', $id)->get();
    
        return view('detalle_despacho', compact('despacho', 'detallesDespacho'));
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
