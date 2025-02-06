<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReparacionRequest;
use App\Http\Requests\UpdateReparacionRequest;
use App\Models\Reparacion;
use App\Models\Cliente;
use App\Models\Tabla;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ReparacionCreated;







class ReparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $user_id = Auth::id();
        $reparaciones = Reparacion::where('user_id', $user_id)->get();



        return view('reparacion.index', compact('reparaciones'));
    }
    /**
     * Show the form for creating a new resource.
     */




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tablas = Tabla::all();
        $clientes = Cliente::all();


        //$tablas=Tabla::pluck('Modelo,','id');
        return view('reparacion.create', compact('tablas', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReparacionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReparacionRequest $request)
    {
        $datos_reparacion = $request->except('_token');
        $datos_reparacion['user_id'] = Auth::id();

        Reparacion::insert($datos_reparacion);
        $reparaciones = Reparacion::orderBy('id', 'desc')->get();

        return view('reparacion.index', compact('reparaciones'));

        // Dispara el evento ReparacionCreated con los datos de la reparación


        return response()->view('reparacion.index', compact('reparaciones'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reparacion  $reparacion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $reparacion = Reparacion::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->firstOrFail();

        $tablas = Tabla::all();
        $clientes = Cliente::all();
        $user = User::all();



        return view('reparacion.show', compact('reparacion', 'tablas', 'clientes', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reparacion  $reparacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reparacion = Reparacion::findOrFail($id);
        $tablas = Tabla::all();
        $clientes = Cliente::all();


        return view('reparacion.edit', compact('reparacion', 'tablas', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReparacionRequest  $request
     * @param  \App\Models\Reparacion  $reparacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReparacionRequest $request, $id)
    {
        $datos_reparacion = $request->except('_token', '_method');
        Reparacion::where('id', '=', $id)->update($datos_reparacion);
        $reparacion = Reparacion::findOrFail($id);
        $tablas = Tabla::all();
        $clientes = Cliente::all();
        $reparaciones = Reparacion::orderBy('id', 'desc')->get();




        return view('reparacion.index', compact('reparaciones'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reparacion  $reparacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reparacion::destroy($id);
        return redirect('reparaciones')->with('success', 'Reparación eliminada');
    }
    public function email($id)
    {
        $cliente = Cliente::find($id);

        return view('email.reparacion_created', ['cliente' => $cliente]);
    }
    public function dashboard()
    {
        // Obtener las reparaciones del usuario autenticado
        $user_id = Auth::id();
        $completedRepairs = Reparacion::where('user_id', $user_id)->where('estado', 'terminado')->count();
        $inProgressRepairs = Reparacion::where('user_id', $user_id)->where('estado', 'en-proceso')->count();
        $notStartedRepairs = Reparacion::where('user_id', $user_id)->where('estado', 'sin-empezar')->count();

        return view('dashboard', [
            'completedRepairs' => $completedRepairs,
            'inProgressRepairs' => $inProgressRepairs,
            'notStartedRepairs' => $notStartedRepairs,
        ]);
    }
}
