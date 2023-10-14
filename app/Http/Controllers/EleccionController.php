<?php

namespace App\Http\Controllers;

use App\Models\Eleccion;
use Illuminate\Http\Request;

class EleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['eleccionescreadas']=Eleccion::where('estado', 1)->paginate(20);
        return view('elecciones.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('elecciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //$datosEleccion = request()->all();
        $datosEleccion = request()->except('_token');
        $datosEleccion['estado'] = $request->input('estado', 1);
        Eleccion::insert($datosEleccion);

        if($request->hasFile('convocatoria')){
            $datosEleccion['convocatoria']=$request->file('convocatoria')->store('uploads','public');
        }
        return redirect('/elecciones')->with('success', 'La elección se ha guardado con éxito.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eleccion  $eleccion
     * @return \Illuminate\Http\Response
     */
    public function show(Eleccion $eleccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eleccion  $eleccion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $elecciones=Eleccion::FindOrFail($id);
        return view('elecciones.edit', compact('elecciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eleccion  $eleccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $datosEleccion = request()->except(['_token','_method']);
        Eleccion::where('id','=',$id)->update($datosEleccion);

        $elecciones=Eleccion::FindOrFail($id);
        return redirect('/elecciones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eleccion  $eleccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eleccion $eleccion)
    {
        //
    }

    public function archivar($id)
    {
        $eleccion = Eleccion::findOrFail($id);
        $eleccion->estado = 0;
        $eleccion->save();

        return redirect('/elecciones');
    }
}