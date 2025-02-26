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
            'Fecha.required'            => 'La fecha es obligatoria.',
            'Fecha.date'                => 'La fecha debe ser válida.',
            'Estado.required'           => 'El estado es obligatorio.',
            'Estado.in'                 => 'El estado debe ser: Presente, Ausente Justificado o Ausente Injustificado.',
            'Hora_Ingreso.date_format'  => 'La hora de ingreso debe estar en formato HH:MM.',
            'Hora_Salida.date_format'   => 'La hora de salida debe estar en formato HH:MM.',
            'Hora_Salida.after_or_equal' => 'La hora de salida debe ser igual o posterior a la hora de ingreso.',
            'Observacion.string'        => 'La observación debe ser un texto.',
            'Observacion.max'           => 'La observación no puede superar los 255 caracteres.',
            'usuario_id.required'       => 'El usuario es obligatorio.',
            'usuario_id.exists'         => 'El usuario seleccionado no es válido.',
            'sala_id.required'          => 'La sala es obligatoria.',
            'sala_id.exists'            => 'La sala seleccionada no es válida.',
            'infante_id.required'       => 'El infante es obligatorio.',
            'infante_id.exists'         => 'El infante seleccionado no es válido.',
        ];
    }
}
