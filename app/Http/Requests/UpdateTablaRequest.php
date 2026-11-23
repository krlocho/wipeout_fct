<?php // PHP opening tag

namespace App\Http\Requests; // Namespace declaration for form requests

use Illuminate\Foundation\Http\FormRequest; // Import base FormRequest class

class UpdateTablaRequest extends FormRequest { // Form request for surfboard updates
    public function authorize(): bool { // Check authorization status
        return true; // Allow request through policy check
    } // End of authorize method

    public function rules(): array { // Define input validation rules
        return [ // Return associative validation rules
            'Modelo' => ['required', 'string', 'max:100'], // Require surfboard model name
            'Marca' => ['required', 'string', 'max:100'], // Require shaper brand name
            'Color' => ['nullable', 'string', 'max:50'], // Optional color or design string
        ]; // Close rules array
    } // End of rules method

    public function messages(): array { // Define user-friendly validation messages
        return [ // Return custom message dictionary
            'Modelo.required' => 'El modelo de la tabla es obligatorio.', // Missing model message
            'Marca.required' => 'La marca o shaper es obligatorio.', // Missing brand message
        ]; // Close messages array
    } // End of messages method
} // End of UpdateTablaRequest class
