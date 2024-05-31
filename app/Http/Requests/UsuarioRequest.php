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
            'Legajo'     => ['required', 'string', 'size:13', Rule::unique('usuario', 'Legajo')->ignore($id), 'regex:/^[0-9\/\-]+$/'],
            'Nombre'     => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'], // Solo letras
            'Apellido'   => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'], // Solo letras
            'Categoria'  => ['required', 'string', 'max:11', 'in:Invitado,Bienestar,Coordinador,Maestro'],
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
            'Legajo.required'   => 'El legajo es obligatorio.',
            'Legajo.size'       => 'El legajo debe tener :size caracteres.',
            'Legajo.unique'     => 'El legajo ya está en uso.',
            'Legajo.regex'      => 'El legajo solo puede contener números y los símbolos "-","/"',
            'Nombre.required'   => 'El nombre es obligatorio.',
            'Nombre.regex'      => 'El nombre solo puede contener letras y espacios.',
            'Nombre.max'        => 'El nombre solo puede tener un máximo de :max caracteres.',
            'Apellido.required' => 'El apellido es obligatorio.',
            'Apellido.regex'    => 'El apellido solo puede contener letras y espacios.',
            'Apellido.max'      => 'El apellido solo puede tener un máximo de :max caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener minimo :min caracteres.',
            'password.max'      => 'La contraseña solo puede tener un máximo de :max caracteres.',
        ];
    }

}
