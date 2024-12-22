<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Tipo'        => ['required', 'string', 'in:Vacuna,Alergia,Discapacidad'],
            'Nombre'      => ['required', 'string', 'max:60'],
            'infante_id'  => ['required', 'exists:infante,id'],
        ];
    }

    public function messages()
    {
        return [
            'Tipo.required'       => 'El tipo es obligatorio.',
            'Tipo.in'             => 'El tipo debe ser: Vacuna, Alergia o Discapacidad.',
            'Nombre.required'     => 'El nombre es obligatorio.',
            'Nombre.max'          => 'El nombre no puede tener más de :max caracteres.',
            'infante_id.required' => 'El infante es obligatorio.',
            'infante_id.exists'   => 'El infante seleccionado no es válido.',
        ];
    }
}