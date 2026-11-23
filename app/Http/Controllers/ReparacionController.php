<?php // PHP opening tag

namespace App\Http\Controllers; // Controller namespace declaration

use App\Http\Requests\StoreReparacionRequest; // Import store request validation
use App\Http\Requests\UpdateReparacionRequest; // Import update request validation
use App\Models\Reparacion; // Import Reparacion model class
use App\Models\Cliente; // Import Cliente model class
use App\Models\Tabla; // Import Tabla model class
use Carbon\Carbon; // Import Carbon library for cross-platform date handling
use Illuminate\Http\JsonResponse; // Import JSON response class
use Illuminate\Http\RedirectResponse; // Import HTTP redirect response class
use Illuminate\Http\Request; // Import standard HTTP request class
use Illuminate\Support\Facades\Auth; // Import Auth facade for session user inspection
use Illuminate\View\View; // Import view response class

class ReparacionController extends Controller { // Controller managing repair lifecycle and tracking
    public function index(): View { // List repairs belonging strictly to authenticated workshop
        $user_id = Auth::id(); // Retrieve the currently authenticated user identifier
        $reparaciones = Reparacion::where('User_id', $user_id) // Filter records by current workshop owner
            ->with(['tablas', 'clientes']) // Eager load board and customer relations to prevent N+1 queries
            ->orderBy('id', 'desc') // Order records by newest first
            ->paginate(15); // Paginate results to protect memory
        return view('reparacion.index', compact('reparaciones')); // Render repairs index blade view
    } // End of index method

    public function kanban(): View { // Render Kanban interactive board
        $user_id = Auth::id(); // Retrieve authenticated workshop user ID
        $reparaciones = Reparacion::where('User_id', $user_id) // Retrieve only tenant repairs
            ->with(['tablas', 'clientes']) // Eager load relations
            ->orderBy('id', 'desc') // Newest repairs first
            ->get(); // Fetch records collection
        $sin_empezar = $reparaciones->where('Estado', 'Sin Empezar'); // Filter pending repairs
        $en_proceso = $reparaciones->where('Estado', 'En Proceso'); // Filter in-progress repairs
        $terminado = $reparaciones->where('Estado', 'Terminado'); // Filter finished repairs
        return view('reparacion.kanban', compact('sin_empezar', 'en_proceso', 'terminado')); // Render kanban board view
    } // End of kanban method

    public function create(): View { // Render form to register a new repair
        $user_id = Auth::id(); // Retrieve current authenticated workshop user identifier
        $tablas = Tabla::where('User_id', $user_id)->orWhere('user_id', $user_id)->get(); // Get only current user surfboards
        $clientes = Cliente::where('User_id', $user_id)->orWhere('user_id', $user_id)->get(); // Get only current user clients
        return view('reparacion.create', compact('tablas', 'clientes')); // Return create form view with scoped data
    } // End of create method

    public function store(StoreReparacionRequest $request): RedirectResponse { // Persist newly created repair record with quick intake support
        $user_id = Auth::id(); // Retrieve current authenticated workshop user identifier
        $validated_input = $request->validated(); // Retrieve strictly validated input attributes
        if (empty($validated_input['Cliente_id']) && !empty($validated_input['nuevo_cliente_nombre'])) { // Check if new client should be auto-created
            $created_cliente = Cliente::create([ // Persist new client record
                'Nombre' => $validated_input['nuevo_cliente_nombre'], // Client first name
                'Telefono' => $validated_input['nuevo_cliente_telefono'] ?? 'Sin teléfono', // Client phone number
                'Email' => $validated_input['nuevo_cliente_email'] ?? null, // Client email
                'User_id' => $user_id, // Assign workshop ownership
                'user_id' => $user_id, // Compatibility column alias
            ]); // Close client creation
            $validated_input['Cliente_id'] = $created_cliente->id; // Assign newly generated client ID
        } // Close client auto-creation
        if (empty($validated_input['Tabla_id']) && !empty($validated_input['nuevo_tabla_modelo'])) { // Check if new board should be auto-created
            $created_tabla = Tabla::create([ // Persist new surfboard record
                'Modelo' => $validated_input['nuevo_tabla_modelo'], // Board model name
                'Marca' => $validated_input['nuevo_tabla_marca'] ?? 'Custom', // Board brand or shaper
                'Color' => $validated_input['nuevo_tabla_color'] ?? null, // Board artwork color
                'User_id' => $user_id, // Assign workshop ownership
                'user_id' => $user_id, // Compatibility column alias
            ]); // Close surfboard creation
            $validated_input['Tabla_id'] = $created_tabla->id; // Assign newly generated board ID
        } // Close board auto-creation
        if ($request->hasFile('foto')) { // Check if damage photo was uploaded
            $uploaded_path = $request->file('foto')->store('reparaciones', 'public'); // Store image in public disk
            $validated_input['foto_url'] = '/storage/' . $uploaded_path; // Generate accessible public URL
        } // Close photo upload check
        $validated_input['User_id'] = $user_id; // Force ownership to currently authenticated user
        if (empty($validated_input['Estado'])) { // Set default status if not explicitly provided
            $validated_input['Estado'] = 'Sin Empezar'; // Assign initial default status value
        } // Close default status check
        unset($validated_input['foto'], $validated_input['nuevo_cliente_nombre'], $validated_input['nuevo_cliente_telefono'], $validated_input['nuevo_cliente_email'], $validated_input['nuevo_tabla_modelo'], $validated_input['nuevo_tabla_marca'], $validated_input['nuevo_tabla_color']); // Strip non-column attributes
        Reparacion::create($validated_input); // Create repair record triggering auto tracking_code assignment
        return redirect()->route('reparaciones.kanban')->with('success', 'Reparación creada e incorporada al taller.'); // Redirect to kanban view
    } // End of store method

    public function show(Request $request, $id = null): View|RedirectResponse { // Display repair details for owner or redirect
        $user_id = Auth::id(); // Retrieve current authenticated workshop user identifier
        $target_id = $id ?? $request->query('id'); // Resolve requested repair identifier
        $reparacion = Reparacion::where('User_id', $user_id) // Scope query to workshop owner
            ->with(['tablas', 'clientes', 'user']) // Eager load all related models
            ->find($target_id); // Look up repair by primary key
        if (!$reparacion) { // Verify if repair exists and belongs to current user
            return redirect()->route('reparaciones.index')->withErrors(['error' => 'Reparación no encontrada.']); // Redirect back
        } // Close existence check
        return view('reparacion.show', compact('reparacion')); // Render repair details view
    } // End of show method

    public function imprimir_ticket($id): View { // Render printable workshop ticket and customer claim stub
        $user_id = Auth::id(); // Retrieve current authenticated workshop user identifier
        $reparacion = Reparacion::where('User_id', $user_id) // Scope query strictly to workshop owner
            ->with(['tablas', 'clientes', 'users']) // Eager load relations
            ->findOrFail($id); // Find repair record strictly for current user
        $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode(route('reparaciones.track', ['code' => $reparacion->tracking_code])); // Generate high-res QR code URL
        return view('reparacion.ticket', compact('reparacion', 'qr_url')); // Render printable ticket blade view
    } // End of imprimir_ticket method

    public function edit($id): View { // Render form to edit an existing repair
        $user_id = Auth::id(); // Retrieve current authenticated user identifier
        $reparacion = Reparacion::where('User_id', $user_id)->findOrFail($id); // Find repair enforcing tenant ownership
        $tablas = Tabla::where('User_id', $user_id)->orWhere('user_id', $user_id)->get(); // Retrieve only tenant surfboards
        $clientes = Cliente::where('User_id', $user_id)->orWhere('user_id', $user_id)->get(); // Retrieve only tenant clients
        return view('reparacion.edit', compact('reparacion', 'tablas', 'clientes')); // Render edit view
    } // End of edit method

    public function update(UpdateReparacionRequest $request, $id): RedirectResponse { // Update existing repair record
        $user_id = Auth::id(); // Retrieve current authenticated user identifier
        $reparacion = Reparacion::where('User_id', $user_id)->findOrFail($id); // Find repair enforcing tenant ownership
        $validated_input = $request->validated(); // Retrieve validated input attributes
        if ($request->hasFile('foto')) { // Check if new damage photo was uploaded
            $uploaded_path = $request->file('foto')->store('reparaciones', 'public'); // Store image in public disk
            $validated_input['foto_url'] = '/storage/' . $uploaded_path; // Set updated photo URL
        } // Close photo upload check
        if (isset($validated_input['Estado']) && $validated_input['Estado'] === 'Terminado' && empty($validated_input['Fecha_salida'])) { // Check if completed
            $validated_input['Fecha_salida'] = Carbon::now()->toDateString(); // Auto-assign completion departure date
        } // Close completion date check
        unset($validated_input['foto']); // Remove temporary file attribute
        $reparacion->update($validated_input); // Update record with validated attributes
        return redirect()->route('reparaciones.kanban')->with('success', 'Reparación actualizada.'); // Redirect to kanban board
    } // End of update method

    public function update_estado(Request $request, $id): JsonResponse|RedirectResponse { // Fast status update endpoint for Kanban board
        $user_id = Auth::id(); // Retrieve authenticated workshop user ID
        $reparacion = Reparacion::where('User_id', $user_id)->findOrFail($id); // Find repair scoping strictly to owner
        $nuevo_estado = $request->input('estado'); // Read requested new status
        if (!in_array($nuevo_estado, ['Sin Empezar', 'En Proceso', 'Terminado'], true)) { // Validate status value strictly
            return response()->json(['error' => 'Estado inválido'], 422); // Return validation error
        } // Close status validation
        $update_payload = ['Estado' => $nuevo_estado]; // Prepare update payload
        if ($nuevo_estado === 'Terminado' && empty($reparacion->Fecha_salida)) { // If finishing repair
            $update_payload['Fecha_salida'] = Carbon::now()->toDateString(); // Set completion departure date
        } // Close completion date check
        $reparacion->update($update_payload); // Persist status update
        if ($request->wantsJson()) { // Check if request was triggered via AJAX
            return response()->json(['success' => true, 'estado' => $reparacion->Estado]); // Return JSON response
        } // Close JSON check
        return redirect()->back()->with('success', 'Estado actualizado a: ' . $reparacion->Estado); // Redirect back
    } // End of update_estado method

    public function destroy($id): RedirectResponse { // Remove repair record from database
        $user_id = Auth::id(); // Retrieve current authenticated user identifier
        $reparacion = Reparacion::where('User_id', $user_id)->findOrFail($id); // Find repair enforcing tenant ownership
        $reparacion->delete(); // Delete record safely
        return redirect()->route('reparaciones.index')->with('success', 'Reparación eliminada correctamente.'); // Redirect with message
    } // End of destroy method

    public function dashboard(): View { // Render analytics dashboard with metrics
        $user_id = Auth::id(); // Retrieve current authenticated workshop user identifier
        $completed_repairs = Reparacion::where('User_id', $user_id)->where('Estado', 'Terminado')->count(); // Count completed jobs
        $in_progress_repairs = Reparacion::where('User_id', $user_id)->where('Estado', 'En Proceso')->count(); // Count ongoing jobs
        $not_started_repairs = Reparacion::where('User_id', $user_id)->where('Estado', 'Sin Empezar')->count(); // Count pending jobs
        $all_repairs = Reparacion::where('User_id', $user_id)->get(); // Fetch repairs for date aggregation in PHP
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']; // Month names in Spanish
        $datos = array_fill(0, 12, 0); // Initialize zero counts for all 12 calendar months
        foreach ($all_repairs as $repair_record) { // Iterate through each repair to accumulate monthly volume
            if (!empty($repair_record->Fecha_llegada)) { // Ensure arrival date is present
                $month_index = (int) Carbon::parse($repair_record->Fecha_llegada)->format('n') - 1; // Compute 0-indexed month
                if ($month_index >= 0 && $month_index < 12) { // Ensure index is within 0-11 range
                    $datos[$month_index]++; // Increment tally for that calendar month
                } // Close index bounds check
            } // Close arrival date check
        } // Close repairs iteration loop
        return view('dashboard', [ // Render dashboard view with computed metrics
            'completedRepairs' => $completed_repairs, // Pass count of finished repairs
            'inProgressRepairs' => $in_progress_repairs, // Pass count of repairs in progress
            'notStartedRepairs' => $not_started_repairs, // Pass count of unstarted repairs
            'datos' => $datos, // Pass monthly aggregation counts array
            'meses' => $meses, // Pass localized month label names array
        ]); // Close view parameters array
    } // End of dashboard method

    public function filtrar_por_estado($estado): View { // Filter repairs listing by specific progress status
        $user_id = Auth::id(); // Retrieve current authenticated user identifier
        $reparaciones = Reparacion::where('User_id', $user_id) // Restrict records to current workshop
            ->where('Estado', $estado) // Filter by status string
            ->with(['tablas', 'clientes']) // Eager load board and customer relations
            ->orderBy('id', 'desc') // Order by latest
            ->paginate(15); // Paginate results
        return view('reparacion.index', compact('reparaciones')); // Return view with filtered repairs
    } // End of filtrar_por_estado method

    public function track(Request $request, $code = null): View { // Public tracking portal for surfboards
        $search_code = strtoupper(trim((string) ($code ?? $request->query('code', $request->query('tracking_code', ''))))); // Normalize code
        $reparacion = null; // Initialize repair variable as null
        if (!empty($search_code)) { // If tracking code was provided
            $reparacion = Reparacion::where('tracking_code', $search_code) // Search by unique tracking code
                ->with(['tablas', 'clientes', 'user']) // Eager load associated records
                ->first(); // Retrieve matching record
        } // Close code search check
        return view('reparacion.track', [ // Render public customer tracking view
            'reparacion' => $reparacion, // Matching repair model instance or null
            'search_code' => $search_code, // Submitted tracking query string
        ]); // Close view data array
    } // End of track method
} // End of ReparacionController class
