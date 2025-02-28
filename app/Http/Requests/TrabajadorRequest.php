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
            'Hora.required'  => 'Horas obligatorias.',
            'Hora.integer'   => 'Debe ser un número entero.',
            'Hora.min'       => 'Mínimo :min horas.',
            'Hora.max'       => 'Máximo :max horas.',
            'Cargo.required' => 'Cargo obligatorio.',
            'Cargo.regex'    => 'Solo letras y espacios.',
            'Cargo.max'      => 'Máximo :max caracteres.',
            'Tipo.required'  => 'Tipo obligatorio.',
            'Tipo.in'        => 'Debe ser "Docente" o "No docente".',
            'tutor_id.required' => 'Tutor obligatorio.',
            'tutor_id.exists'   => 'Tutor inválido.',
        ];
    }
    
}
