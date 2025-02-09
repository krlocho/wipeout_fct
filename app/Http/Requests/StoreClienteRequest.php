<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'Nombre' => 'required|max:50',
            'Apellido' => 'required|max:50',
            'Direccion' => 'required|max:100',
            'Telefono' => 'required|max:20',
            'Email' => 'required|email:rfc,dns|max:50',
        ];
    }
    public function messages()
    {
        return [
            'Nombre.required' => 'El campo nombre es obligatorio',
            'Email.required' => 'El campo email es obligatorio',
            'Email.email' => 'El campo email debe ser un email válido y contener un punto',
            'Email.unique' => 'El email ya está en uso',
            'Telefono.max' => 'El campo teléfono no puede tener más de 20 caracteres',
        ];
    }
}
