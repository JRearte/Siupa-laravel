<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
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
    public function rules()
    {
        $id = $this->route('usuario');
        return [
            'Legajo'     => ['required', 'string', 'max:13', Rule::unique('usuario', 'Legajo')->ignore($id), 'regex:/^[0-9\/\-]+$/'],
            'Nombre'     => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'], // Solo letras
            'Apellido'   => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'], // Solo letras
            'Categoria'  => ['required', 'string'],
            'password'   => ['required', 'string', 'min:8', 'max:60'],
            'Habilitado' => ['boolean'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'Legajo.required'   => 'Legajo obligatorio.',
            'Legajo.max'        => 'Máximo :max caracteres.',
            'Legajo.unique'     => 'Legajo en uso.',
            'Legajo.regex'      => 'Solo números y símbolos "-" y "/".',
            'Nombre.required'   => 'Nombre obligatorio.',
            'Nombre.regex'      => 'Solo letras y espacios.',
            'Nombre.max'        => 'Máximo :max caracteres.',
            'Apellido.required' => 'Apellido obligatorio.',
            'Apellido.regex'    => 'Solo letras y espacios.',
            'Apellido.max'      => 'Máximo :max caracteres.',
            'password.required' => 'Contraseña obligatoria.',
            'password.min'      => 'Mínimo :min caracteres.',
            'password.max'      => 'Máximo :max caracteres.',
        ];
    }

}
