<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsistenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Fecha'         => ['required', 'date'],
            'Inasistencia'  => ['nullable', 'in:Justificado,Injustificado'],
            'usuario_id'    => ['required', 'exists:usuario,id'],
            'sala_id'       => ['required', 'exists:sala,id'],
            'infante_id'    => ['required', 'exists:infante,id'],
        ];
    }

    public function messages()
    {
        return [
            'Fecha.required'        => 'La fecha es obligatoria.',
            'Fecha.date'            => 'La fecha debe ser válida.',
            'Inasistencia.in'       => 'La inasistencia debe ser: Justificado o Injustificado.',
            'usuario_id.required'   => 'El usuario es obligatorio.',
            'usuario_id.exists'     => 'El usuario seleccionado no es válido.',
            'sala_id.required'      => 'La sala es obligatoria.',
            'sala_id.exists'        => 'La sala seleccionada no es válida.',
            'infante_id.required'   => 'El infante es obligatorio.',
            'infante_id.exists'     => 'El infante seleccionado no es válido.',
        ];
    }
}