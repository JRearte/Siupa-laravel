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
            'Estado'        => ['required', 'in:Presente,Ausente Justificado,Ausente Injustificado'],
            'Hora_Ingreso'  => ['nullable', 'date_format:H:i'],
            'Hora_Salida'   => ['nullable', 'date_format:H:i', 'after_or_equal:Hora_Ingreso'],
            'Observacion'   => ['nullable', 'string', 'max:255'],
            'usuario_id'    => ['required', 'exists:usuario,id'],
            'sala_id'       => ['required', 'exists:sala,id'],
            'infante_id'    => ['required', 'exists:infante,id'],
        ];
    }

    public function messages()
    {
        return [
            'Fecha.required'           => 'Fecha obligatoria.',
            'Fecha.date'               => 'Fecha no válida.',
            'Estado.required'          => 'Estado obligatorio.',
            'Estado.in'                => 'Debe ser: Presente, Ausente Justificado o Injustificado.',
            'Hora_Ingreso.date_format' => 'Formato HH:MM requerido.',
            'Hora_Salida.date_format'  => 'Formato HH:MM requerido.',
            'Hora_Salida.after_or_equal' => 'Debe ser igual o posterior a la hora de ingreso.',
            'Observacion.string'       => 'Debe ser texto.',
            'Observacion.max'          => 'Máximo 255 caracteres.',
            'usuario_id.required'      => 'Usuario obligatorio.',
            'usuario_id.exists'        => 'Usuario no válido.',
            'sala_id.required'         => 'Sala obligatoria.',
            'sala_id.exists'           => 'Sala no válida.',
            'infante_id.required'      => 'Infante obligatorio.',
            'infante_id.exists'        => 'Infante no válido.',
        ];
    }
}
