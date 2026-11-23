<?php // PHP opening tag

namespace App\Http\Requests; // Namespace for request validators

use Illuminate\Foundation\Http\FormRequest; // Import base FormRequest class

class StoreClienteRequest extends FormRequest { // Form request for creating customer records
    public function authorize(): bool { // Check authorization
        return true; // Allow authenticated user request
    } // End of authorize method

    public function rules(): array { // Define validation rules
        return [ // Return associative validation rules
            'Nombre' => ['required', 'string', 'max:100'], // Require client first name
            'Apellido' => ['nullable', 'string', 'max:100'], // Optional client surname
            'Direccion' => ['nullable', 'string', 'max:255'], // Optional address string
            'Telefono' => ['required', 'string', 'max:30'], // Require contact phone number
            'Email' => ['nullable', 'email', 'max:100'], // Optional valid email format without dns lookup
        ]; // Close rules array
    } // End of rules method

    public function messages(): array { // Define custom validation feedback messages
        return [ // Return associative messages array
            'Nombre.required' => 'El nombre del cliente es obligatorio.', // Message for missing name
            'Telefono.required' => 'El teléfono de contacto es obligatorio.', // Message for missing phone
            'Email.email' => 'El email debe tener un formato válido.', // Message for invalid email
        ]; // Close messages array
    } // End of messages method
} // End of StoreClienteRequest class
