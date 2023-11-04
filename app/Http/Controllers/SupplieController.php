<?php

namespace App\Http\Controllers;

use App\Models\Supplie;
use Illuminate\Http\Request;

class SupplieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplies = Supplie::all();
        return view('materias', compact('supplies'));
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
           
        $supplie = new Supplie;
        $supplie->code_sup =$request->input('txt_codigo_materia');
        $supplie->name_sup=$request->input('txt_nombre_materia');
        $supplie->stock_sup=$request->input('txt_stock_materia');
        
        $supplie->save();      
        return redirect('/')->with('success', 'Materia prima ingresada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplie  $supplie
     * @return \Illuminate\Http\Response
     */
    public function show(Supplie $supplie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplie  $supplie
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplie $supplie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplie  $supplie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplie = Supplie::findOrFail($id);

        $stockChange = (int) $request->input('stock_change');
        $action = $request->input('action');

        if ($action === 'increase') {
            $supplie->stock_sup += $stockChange;
        } elseif ($action === 'decrease') {
            if ($stockChange > $supplie->stock_sup) {
                return redirect()->route('suplies.index')->with('error', 'No puedes disminuir más de lo que hay en stock.');
            }
            $supplie->stock_sup -= $stockChange;
        } else {
            return redirect()->route('suplies.index')->with('error', 'Acción no válida.');
        }

        $supplie->save();

        return redirect()->route('suplies.index')->with('success', 'Stock actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplie  $supplie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplie $supplie)
    {
        //
    }
}
