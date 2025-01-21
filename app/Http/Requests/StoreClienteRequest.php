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
            'Telefono' => 'required|max:10',
            'Email' => 'required|max:50',
        ];
    }
}
