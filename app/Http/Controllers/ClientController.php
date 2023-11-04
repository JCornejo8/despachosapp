<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Client::all();
        return view("clientes", compact("clientes"));
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
            'txt_nombre_cliente' => 'required|string',
            'txt_codigo_cliente' => 'required|string',
        ]);

        // Verifica si el número (código) ya existe en la base de datos
        $existingClient = Client::where('code_cli', $request->input('txt_codigo_cliente'))->first();

        if ($existingClient) {
            return redirect('/')->with('error', 'El número ya pertenece a otro cliente')->withInput(); 
        }

        // Si el número no existe, crea un nuevo cliente
        $client = new Client;
        $client->name_cli = $request->input('txt_nombre_cliente');
        $client->code_cli = $request->input('txt_codigo_cliente');

        // Guarda el cliente en la base de datos
        $client->save();

        return redirect('/')->with('success', 'Cliente guardado correctamente');
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
        // Encuentra el cliente por su ID
        $cliente = Client::find($id);
    
        if (!$cliente) {
            return redirect()->back()->with('error', 'Cliente no encontrado');
        }
    
        // Verifica si el cliente se encuentra en uso
        if ($cliente->exists()) {
            return redirect()->route('clientes.index')->with('error', 'No se puede eliminar, cliente en uso');
        }
    
        // Elimina el cliente
        $cliente->delete();
    
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
