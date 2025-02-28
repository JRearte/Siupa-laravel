<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Valor'          => ['required', 'numeric', 'min:0'], 
            'Fecha'          => ['required', 'date'], 
            'trabajador_id'  => ['required', 'exists:trabajador,id'],
        ];
    }

    public function messages()
    {
        return [
            'Valor.required'         => 'Valor obligatorio.',
            'Valor.numeric'          => 'Debe ser un número.',
            'Valor.min'              => 'No puede ser negativo.',
            'Fecha.required'         => 'Fecha obligatoria.',
            'Fecha.date'             => 'Debe ser válida.',
            'trabajador_id.required' => 'Trabajador obligatorio.',
            'trabajador_id.exists'   => 'Trabajador no válido.',
        ];
    }
    
}
