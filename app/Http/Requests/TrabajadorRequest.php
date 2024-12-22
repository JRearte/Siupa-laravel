<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrabajadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Hora'     => ['required', 'integer', 'min:1', 'max:24'],
            'Cargo'    => ['required', 'string', 'max:35', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Tipo'     => ['required', 'string', 'in:Docente,No docente'],
            'tutor_id' => ['required', 'exists:tutor,id'],
        ];
    }

    public function messages()
    {
        return [
            'Hora.required'     => 'El número de horas es obligatorio.',
            'Hora.integer'      => 'El número de horas debe ser un número entero.',
            'Hora.min'          => 'El número mínimo de horas es :min.',
            'Hora.max'          => 'El número máximo de horas es :max.',
            'Cargo.required'    => 'El cargo es obligatorio.',
            'Cargo.regex'       => 'El cargo solo puede contener letras y espacios.',
            'Cargo.max'         => 'El cargo puede tener un máximo de :max caracteres.',
            'Tipo.required'     => 'El tipo de trabajador es obligatorio.',
            'Tipo.in'           => 'El tipo debe ser "Docente" o "No docente".',
            'tutor_id.required' => 'El tutor asociado es obligatorio.',
            'tutor_id.exists'   => 'El tutor seleccionado no es válido.',
        ];
    }
}
