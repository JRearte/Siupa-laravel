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
            'Tipo.required'       => 'Tipo obligatorio.',
            'Tipo.in'             => 'Debe ser Vacuna, Alergia o Discapacidad.',
            'Nombre.required'     => 'Descripción obligatoria.',
            'Nombre.max'          => 'Máximo :max caracteres.',
            'infante_id.required' => 'Infante obligatorio.',
            'infante_id.exists'   => 'Infante no válido.',
        ];
    }
    
}