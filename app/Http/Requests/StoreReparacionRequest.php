<?php // PHP opening tag

namespace App\Http\Requests; // Namespace for request validators

use Illuminate\Foundation\Http\FormRequest; // Import base FormRequest class

class StoreReparacionRequest extends FormRequest { // Form request for creating repair orders
    public function authorize(): bool { // Determine whether user is authorized
        return true; // Allow authenticated user to submit creation request
    } // End of authorize method

    public function rules(): array { // Validation rules array
        return [ // Return associative array of validation rules
            'Fecha_llegada' => ['required', 'date'], // Require valid arrival date
            'Fecha_salida' => ['nullable', 'date'], // Optional completion departure date
            'Precio' => ['nullable', 'numeric', 'min:0'], // Optional non-negative numeric price
            'Reparacion' => ['required', 'string', 'max:255'], // Require concise description of damage
            'Tabla_id' => ['nullable', 'integer'], // Optional existing surfboard identifier
            'Cliente_id' => ['nullable', 'integer'], // Optional existing customer identifier
            'nuevo_cliente_nombre' => ['nullable', 'string', 'max:100'], // Optional quick intake new client name
            'nuevo_cliente_telefono' => ['nullable', 'string', 'max:30'], // Optional quick intake new client phone
            'nuevo_cliente_email' => ['nullable', 'email', 'max:100'], // Optional quick intake new client email
            'nuevo_tabla_modelo' => ['nullable', 'string', 'max:100'], // Optional quick intake new board model
            'nuevo_tabla_marca' => ['nullable', 'string', 'max:100'], // Optional quick intake new board brand
            'nuevo_tabla_color' => ['nullable', 'string', 'max:50'], // Optional quick intake new board color
            'foto' => ['nullable', 'image', 'max:10240'], // Optional damage inspection photo file up to 10MB
            'Estado' => ['nullable', 'string', 'in:Sin Empezar,En Proceso,Terminado'], // Optional progress status
            'Observaciones' => ['nullable', 'string', 'max:1000'], // Optional notes and observations
        ]; // Close rules array
    } // End of rules method

    public function with_validator($validator): void { // Custom validation rules logic
        $validator->after(function ($validator_instance) { // Add post-validation checks
            $current_user = $this->user(); // Retrieve authenticated user instance
            if ($current_user && $current_user->has_reached_monthly_limit()) { // Check free tier quota
                $validator_instance->errors()->add('plan', 'Has alcanzado el límite de 5 tablas mensuales del plan gratuito. Actualiza a Taller Pro para reparaciones ilimitadas.'); // Add limit error
            } // Close quota check
            if (empty($this->input('Cliente_id')) && empty($this->input('nuevo_cliente_nombre'))) { // Check client existence
                $validator_instance->errors()->add('Cliente_id', 'Debes seleccionar un cliente existente o indicar el nombre de uno nuevo.'); // Add error
            } // Close client check
            if (empty($this->input('Tabla_id')) && empty($this->input('nuevo_tabla_modelo'))) { // Check board existence
                $validator_instance->errors()->add('Tabla_id', 'Debes seleccionar una tabla existente o indicar el modelo de una nueva.'); // Add error
            } // Close board check
        }); // Close after validation callback
    } // End of with_validator method

    public function withValidator($validator): void { // CamelCase alias for Laravel validation dispatcher
        $this->with_validator($validator); // Delegate to snake_case implementation
    } // End of withValidator method
} // End of StoreReparacionRequest class
