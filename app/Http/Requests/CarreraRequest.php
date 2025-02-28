<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarreraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('carrera');

        return [
            'Codigo'    => ['required', 'integer', 'digits:3'],
            'Nombre'    => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'tutor_id'  => ['required', Rule::unique('carrera', 'tutor_id')->ignore($id), 'exists:tutor,id'],
        ];
    }

    public function messages()
    {
        return [
            'Codigo.required'   => 'Código obligatorio.',
            'Codigo.integer'    => 'Debe ser un número.',
            'Codigo.digits'     => 'Debe tener :digits dígitos.',
            'Nombre.required'   => 'Nombre obligatorio.',
            'Nombre.regex'      => 'Solo letras y espacios.',
            'Nombre.max'        => 'Máximo :max caracteres.',
            'tutor_id.required' => 'Tutor obligatorio.',
            'tutor_id.unique'   => 'El tutor ya tiene carrera.',
            'tutor_id.exists'   => 'Tutor no válido.',
        ];
    }
    
}