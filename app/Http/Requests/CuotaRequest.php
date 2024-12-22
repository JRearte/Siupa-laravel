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
            'Valor.required'         => 'El valor de la cuota es obligatorio.',
            'Valor.numeric'          => 'El valor de la cuota debe ser un número.',
            'Valor.min'              => 'El valor de la cuota no puede ser negativo.',
            'Fecha.required'         => 'La fecha de la cuota es obligatoria.',
            'Fecha.date'             => 'La fecha debe ser válida.',
            'trabajador_id.required' => 'El trabajador asociado es obligatorio.',
            'trabajador_id.exists'   => 'El trabajador seleccionado no es válido.',
        ];
    }
}
