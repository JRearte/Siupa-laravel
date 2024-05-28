<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalaRequest extends FormRequest
{
    /**
     * Determina si el usuario esta autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('sala');
        return [
            'Nombre'    => ['required', 'string', 'max:30', RULE::unique('sala', 'Nombre')->ignore($id), 'regex:/^[\p{L}\s]+$/u'],
            'Edad'      => ['required', 'integer', 'min:0', 'max:6'], //La edad puede ser de 0 a 6 años.
            'Capacidad' => ['required', 'integer', 'digits_between:1,2'], //La capacidad comprende de 1 a 2 digitos.
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'Nombre.required'          => 'El nombre es obligatorio.',
            'Nombre.max'               => 'El nombre solo puede tener un máximo de :max caracteres.',
            'Nombre.unique'            => 'El nombre ya está en uso.',
            'Nombre.regex'             => 'El nombre solo puede contener letras y espacios.',
            'Edad.required'            => 'La edad es obligatorio.',
            'Edad.integer'             => 'La edad debe ser un número entero.',
            'Edad.min'                 => 'La edad minima es de :min año.',
            'Edad.max'                 => 'La edad máxima es de :max años.',
            'Capacidad.required'       => 'La capacidad es obligatorio.',
            'Capacidad.integer'        => 'La capacidad debe ser un número entero.',
            'Capacidad.digits_between' => 'La capacidad debe tener entre 1 y 2 dígitos.',
        ];
    }
}
