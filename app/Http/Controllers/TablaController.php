<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTablaRequest;
use App\Http\Requests\UpdateTablaRequest;
use App\Models\Tabla;
use Illuminate\Support\Facades\Auth;

class TablaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $tablas = Tabla::where('user_id', $user_id)->get();

        return response()->view('tabla.index', compact('tablas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('tabla.create');
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


        $datos_tabla = $request->except('_token');
        $datos_tabla['user_id'] = Auth::id();
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
        return response()->view('tabla.show', compact('tabla'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tabla  $tabla
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tabla = Tabla::findOrFail($id);
        return response()->view('tabla.edit', compact('tabla'));
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
        $datos_tabla = $request->except('_token', '_method');
        Tabla::where('id', '=', $id)->update($datos_tabla);
        $tabla = Tabla::findOrFail($id);

        return redirect()->route('tablas.index');
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
        return redirect()->route('tablas.index');
    }
}
