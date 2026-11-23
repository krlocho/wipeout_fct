<?php // PHP opening tag

namespace App\Http\Requests; // Namespace for request validators

use Illuminate\Foundation\Http\FormRequest; // Import base FormRequest class

class UpdateReparacionRequest extends FormRequest { // Form request for updating existing repair orders
    public function authorize(): bool { // Determine whether user is authorized
        return true; // Allow request execution through controller policy
    } // End of authorize method

    public function rules(): array { // Validation rules array
        return [ // Return associative array of validation rules
            'Fecha_llegada' => ['required', 'date'], // Require valid arrival date
            'Fecha_salida' => ['nullable', 'date'], // Optional completion departure date
            'Precio' => ['nullable', 'numeric', 'min:0'], // Optional numeric price
            'Reparacion' => ['required', 'string', 'max:255'], // Require description of damage
            'Tabla_id' => ['required', 'integer'], // Associated surfboard identifier
            'Cliente_id' => ['required', 'integer'], // Associated customer identifier
            'foto' => ['nullable', 'image', 'max:10240'], // Optional damage inspection photo file up to 10MB
            'Estado' => ['required', 'string', 'in:Sin Empezar,En Proceso,Terminado'], // Progress status
            'Observaciones' => ['nullable', 'string', 'max:1000'], // Optional notes and observations
        ]; // Close rules array
    } // End of rules method
} // End of UpdateReparacionRequest class
