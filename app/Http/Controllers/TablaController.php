<?php // PHP opening tag

namespace App\Http\Controllers; // Controller namespace declaration

use App\Http\Requests\StoreTablaRequest; // Import store request validation class
use App\Http\Requests\UpdateTablaRequest; // Import update request validation class
use App\Models\Tabla; // Import Tabla model class
use Illuminate\Http\RedirectResponse; // Import HTTP redirect response class
use Illuminate\Support\Facades\Auth; // Import Auth facade for session user checks
use Illuminate\View\View; // Import view response class

class TablaController extends Controller { // Controller managing workshop surfboards
    public function index(): View { // Display list of boards belonging to workshop
        $user_id = Auth::id(); // Retrieve current authenticated user identifier
        $tablas = Tabla::where('User_id', $user_id) // Filter boards belonging to workshop
            ->orWhere('user_id', $user_id) // Support lowercase column compatibility
            ->orderBy('id', 'desc') // Order by latest added
            ->paginate(15); // Paginate board results
        return view('tabla.index', compact('tablas')); // Return index blade template
    } // End of index method

    public function create(): View { // Show form to create a new surfboard
        return view('tabla.create'); // Render surfboard create view
    } // End of create method

    public function store(StoreTablaRequest $request): RedirectResponse { // Persist new board record
        $tabla_data = $request->validated(); // Retrieve strictly validated input values
        $tabla_data['User_id'] = Auth::id(); // Force ownership to authenticated user
        $tabla_data['user_id'] = Auth::id(); // Set lowercase column alias for compatibility
        Tabla::create($tabla_data); // Use Eloquent create to trigger casts and timestamps
        return redirect()->route('tablas.index')->with('success', 'Tabla registrada correctamente.'); // Redirect to list
    } // End of store method

    public function show($id): RedirectResponse { // Safely redirect show request to edit view
        return redirect()->route('tablas.edit', $id); // Avoid missing view 500 by redirecting to edit
    } // End of show method

    public function edit($id): View { // Show form to edit existing surfboard
        $user_id = Auth::id(); // Retrieve authenticated user identifier
        $tabla = Tabla::where(function ($query) use ($user_id) { // Query with tenant ownership scope
            $query->where('User_id', $user_id)->orWhere('user_id', $user_id); // Check either column variant
        })->findOrFail($id); // Fail with 404 if record does not belong to user
        return view('tabla.edit', compact('tabla')); // Render edit board view
    } // End of edit method

    public function update(UpdateTablaRequest $request, $id): RedirectResponse { // Update existing surfboard
        $user_id = Auth::id(); // Retrieve authenticated user identifier
        $tabla = Tabla::where(function ($query) use ($user_id) { // Query with tenant ownership scope
            $query->where('User_id', $user_id)->orWhere('user_id', $user_id); // Check either column variant
        })->findOrFail($id); // Ensure record exists and belongs to user
        $tabla->update($request->validated()); // Apply validated attributes
        return redirect()->route('tablas.index')->with('success', 'Tabla actualizada correctamente.'); // Redirect to list
    } // End of update method

    public function destroy($id): RedirectResponse { // Delete surfboard record
        $user_id = Auth::id(); // Retrieve authenticated user identifier
        $tabla = Tabla::where(function ($query) use ($user_id) { // Query with tenant ownership scope
            $query->where('User_id', $user_id)->orWhere('user_id', $user_id); // Check either column variant
        })->findOrFail($id); // Enforce tenant ownership before deleting
        $tabla->delete(); // Delete surfboard record
        return redirect()->route('tablas.index')->with('success', 'Tabla eliminada correctamente.'); // Redirect with feedback
    } // End of destroy method
} // End of TablaController class
