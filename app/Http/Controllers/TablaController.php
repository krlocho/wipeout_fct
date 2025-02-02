<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTablaRequest;
use App\Http\Requests\UpdateTablaRequest;
use App\Models\Tabla;

class TablaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tablas= Tabla::getTablaMayusculas();
        return response()->view('tabla.index', compact('tablas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tabla.create');
    }

    /**
     * Store a newly created resource in storage.
     *
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTablaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTablaRequest $request)
    {


        $datos_tabla= $request->except('_token');
        Tabla::insert($datos_tabla);
        return redirect()->route('tablas.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tabla  $tabla
     * @return \Illuminate\Http\Response
     */
    public function show(Tabla $tabla)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tabla  $tabla
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tabla=Tabla::findOrFail($id);
        return view('tabla.edit',compact('tabla'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTablaRequest  $request
     * @param  \App\Models\Tabla  $tabla
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTablaRequest $request, $id)
    {
        $datos_tabla=$request->except('_token','_method');
        Tabla::where('id','=',$id)->update($datos_tabla);
        $tabla=Tabla::findOrFail($id);

        return redirect('tablas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tabla  $tabla
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tabla::destroy($id);
        return redirect('tablas');
    }
}
