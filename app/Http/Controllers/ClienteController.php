<?php // PHP opening tag

namespace App\Http\Controllers; // Controller namespace declaration

use App\Http\Requests\StoreClienteRequest; // Import store request validation class
use App\Http\Requests\UpdateClienteRequest; // Import update request validation class
use App\Models\Cliente; // Import Cliente model class
use Illuminate\Http\RedirectResponse; // Import HTTP redirect response class
use Illuminate\Support\Facades\Auth; // Import Auth facade for session user checks
use Illuminate\View\View; // Import view response class

class ClienteController extends Controller { // Controller managing workshop clients
    public function index(): View { // Display list of clients belonging to workshop
        $user_id = Auth::id(); // Retrieve current authenticated user identifier
        $clientes = Cliente::where('User_id', $user_id) // Filter records belonging to workshop
            ->orWhere('user_id', $user_id) // Support lowercase column compatibility
            ->orderBy('id', 'desc') // Order by latest added
            ->paginate(15); // Paginate client list
        return view('cliente.index', compact('clientes')); // Return index blade template
    } // End of index method

    public function create(): View { // Show form to create a new client
        return view('cliente.create'); // Render client create view
    } // End of create method

    public function store(StoreClienteRequest $request): RedirectResponse { // Persist new client record
        $cliente_data = $request->validated(); // Retrieve strictly validated input values
        $cliente_data['User_id'] = Auth::id(); // Force ownership to authenticated user
        $cliente_data['user_id'] = Auth::id(); // Set lowercase column alias for compatibility
        Cliente::create($cliente_data); // Use Eloquent create to trigger casts and timestamps
        return redirect()->route('clientes.index')->with('success', 'Cliente añadido correctamente.'); // Redirect to list
    } // End of store method

    public function show($id): RedirectResponse { // Redirect show request to edit view
        return redirect()->route('clientes.edit', $id); // Safely redirect to edit form
    } // End of show method

    public function edit($id): View { // Show form to edit existing client
        $user_id = Auth::id(); // Retrieve authenticated user identifier
        $cliente = Cliente::where(function ($query) use ($user_id) { // Query with tenant ownership scope
            $query->where('User_id', $user_id)->orWhere('user_id', $user_id); // Check either column variant
        })->findOrFail($id); // Fail with 404 if record does not belong to user
        return view('cliente.edit', compact('cliente')); // Render edit client view
    } // End of edit method

    public function update(UpdateClienteRequest $request, $id): RedirectResponse { // Update existing client record
        $user_id = Auth::id(); // Retrieve authenticated user identifier
        $cliente = Cliente::where(function ($query) use ($user_id) { // Query with tenant ownership scope
            $query->where('User_id', $user_id)->orWhere('user_id', $user_id); // Check either column variant
        })->findOrFail($id); // Ensure record exists and belongs to user
        $cliente->update($request->validated()); // Apply validated attributes
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.'); // Redirect to list
    } // End of update method

    public function destroy($id): RedirectResponse { // Delete client record
        $user_id = Auth::id(); // Retrieve authenticated user identifier
        $cliente = Cliente::where(function ($query) use ($user_id) { // Query with tenant ownership scope
            $query->where('User_id', $user_id)->orWhere('user_id', $user_id); // Check either column variant
        })->findOrFail($id); // Enforce tenant ownership before deleting
        $cliente->delete(); // Delete client record
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.'); // Redirect with feedback
    } // End of destroy method
} // End of ClienteController class
