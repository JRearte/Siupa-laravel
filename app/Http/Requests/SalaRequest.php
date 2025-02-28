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
            'Nombre'    => ['required', 'string', 'max:30', RULE::unique('sala', 'Nombre')->ignore($id)],
            'Edad'      => ['required', 'integer', 'min:0', 'max:6'],
            'Capacidad' => ['required', 'integer', 'digits_between:1,2'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'Nombre.required'           => 'Nombre obligatorio.',
            'Nombre.max'                => 'Máximo :max caracteres.',
            'Nombre.unique'             => 'Nombre en uso.',
            'Edad.required'             => 'Edad obligatoria.',
            'Edad.integer'              => 'Debe ser un número entero.',
            'Edad.min'                  => 'Mínimo :min año.',
            'Edad.max'                  => 'Máximo :max años.',
            'Capacidad.required'        => 'Capacidad obligatoria.',
            'Capacidad.integer'         => 'Debe ser un número entero.',
            'Capacidad.digits_between'  => 'Debe tener entre 1 y 2 dígitos.',
        ];
    }
    
}
