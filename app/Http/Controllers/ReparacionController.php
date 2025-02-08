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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()

    {
        $user_id = Auth::id();
        $reparaciones = Reparacion::where('user_id', $user_id)->get();



        return response()->view('reparacion.index', compact('reparaciones'));
    }
    /**
     * Show the form for creating a new resource.
     */




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function store(StoreReparacionRequest $request)
    {
        $datos_reparacion = $request->except('_token');
        $datos_reparacion['user_id'] = Auth::id();

        Reparacion::insert($datos_reparacion);
        $reparaciones = Reparacion::orderBy('id', 'desc')->get();

        return redirect()->route('reparaciones.index');

        // Dispara el evento ReparacionCreated con los datos de la reparación
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reparacion  $reparacion
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function show(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:reparacions,id',
            'user_id' => 'required|integer|exists:users,id',
        ], [
            'id.required' => 'El id de la reparación es requerido',
            'id.integer' => 'El id de la reparación debe ser un número entero',
            'id.exists'  => 'El id de la reparación no es correcto',
            'user_id.required' => 'El id del usuario es requerido',
            'user_id.integer' => 'El id del usuario debe ser un número entero',
            'user_id.exists' => 'El id del usuario no es correcto',
        ]);

        try {
            $reparacion = Reparacion::where('id', $request->id)
                ->where('user_id', $request->user_id)
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->withErrors([
                'id' => 'La reparación no fue encontrada o no pertenece al usuario.',
            ]);
        }

        $tablas = Tabla::all();
        $clientes = Cliente::all();
        $user = User::all();



        return response()->view('reparacion.show', compact('reparacion', 'tablas', 'clientes', 'user'));
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


        return response()->view('reparacion.edit', compact('reparacion', 'tablas', 'clientes'));
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
        $tablas = Tabla::all();
        $clientes = Cliente::all();
        $reparaciones = Reparacion::orderBy('id', 'desc')->get();


        // Asignar la fecha de salida si el estado es "terminado"
        if ($datos_reparacion['Estado'] === 'Terminado') {
            $datos_reparacion['Fecha_salida'] = now();
        }

        Reparacion::where('id', '=', $id)->update($datos_reparacion);
        $reparacion = Reparacion::findOrFail($id);



        return redirect()->route('reparaciones.index');
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
        $completedRepairs = Reparacion::where('user_id', $user_id)->where('estado', 'Terminado')->count();
        $inProgressRepairs = Reparacion::where('user_id', $user_id)->where('estado', 'En Proceso')->count();
        $notStartedRepairs = Reparacion::where('user_id', $user_id)->where('estado', 'Sin Empezar')->count();

        // Obtener las reparaciones por mes
        $reparacionPorMes = Reparacion::selectRaw('COUNT(*) as count, MONTH(Fecha_llegada) as month')
            ->where('user_id', $user_id)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $datos = [];

        foreach ($meses as $index => $mes) {
            $datos[] = $reparacionPorMes[$index + 1] ?? 0;
        }

        return view('dashboard', [
            'completedRepairs' => $completedRepairs,
            'inProgressRepairs' => $inProgressRepairs,
            'notStartedRepairs' => $notStartedRepairs,
            'datos' => $datos,
            'meses' => $meses,
        ]);
    }
    public function filtrarPorEstado($estado)
    {
        $user_id = Auth::id();
        $reparaciones = Reparacion::where('user_id', $user_id)
            ->where('estado', $estado)
            ->get();

        return view('reparacion.index', compact('reparaciones'));
    }
}
