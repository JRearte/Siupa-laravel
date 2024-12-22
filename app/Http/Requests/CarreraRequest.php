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
            'Codigo.required'    => 'El código de la carrera es obligatorio.',
            'Codigo.integer'     => 'El código de la carrera debe ser un número entero.',
            'Codigo.digits'      => 'El código de la carrera debe tener exactamente :digits dígitos.',
            'Nombre.required'    => 'El nombre de la carrera es obligatorio.',
            'Nombre.regex'       => 'El nombre solo puede contener letras y espacios.',
            'Nombre.max'         => 'El nombre puede tener un máximo de :max caracteres.',
            'tutor_id.required'  => 'El tutor asociado es obligatorio.',
            'tutor_id.unique'    => 'El tutor ya tiene una carrera asignada.',
            'tutor_id.exists'    => 'El tutor seleccionado no es válido.',
        ];
    }
}