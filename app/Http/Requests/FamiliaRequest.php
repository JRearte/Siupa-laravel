<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Validation\Rule;

class FamiliaRequest extends FormRequest
{
    /**
     * Determina si el usuario esta autorizado a realizar la solicitud.
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
        $id = $this->route('familia');
        return [
            'Nombre'              => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'],
            'Apellido'            => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'],
            'Vinculo'             => ['required', 'string', 'max:10', 'regex:/^[a-zA-Z ]+$/'],
            'Fecha_de_nacimiento' => ['required', 'date'],
            'Numero_documento'    => ['required', 'integer', 'digits:8', Rule::unique('familia', 'Numero_documento')->ignore($id)],
            'Tipo_documento'      => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'],
            'Lugar_de_trabajo'    => ['string', 'max:50', 'regex:/^[a-zA-Z0-9 ]+$/'],
            'Ingreso'             => ['numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'Habilitado'          => ['boolean'],
        ];
    }


    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'Nombre.required'           => 'El nombre es obligatorio.',
            'Nombre.regex'              => 'El nombre solo puede contener letras y espacios.',
            'Nombre.max'                => 'El nombre solo puede tener un máximo de :max caracteres.',
            'Apellido.required'         => 'El apellido es obligatorio.',
            'Apellido.regex'            => 'El apellido solo puede contener letras y espacios.',
            'Apellido.max'              => 'El apellido solo puede tener un máximo de :max caracteres.',
            'Numero_documento.required' => 'El número de documento es obligatorio.',
            'Numero_documento.unique'   => 'El número de documento ya esta en uso.',
            'Numero_documento.digits'   => 'El número de documento debe tener :digits dígitos.',
            'Numero_documento.integer'  => 'El número de documento solo puede tener números enteros.',
            'Tipo_documento.required'   => 'El tipo de documento es obligatorio.',
            'Tipo_documento.regex'      => 'El tipo de documento solo puede contener letras.',
            'Tipo_documento.max'        => 'El tipo de documento puede tener un máximo de :max caracteres.',
            'Lugar_de_trabajo.regex'    => 'El lugar de trabajo solo puede contener letras y números.',
            'Lugar_de_trabajo.max'      => 'El lugar de trabajo solo puete tener un máximo de :max caracteres.',
            'Ingreso.regex'             => 'El ingreso debe ser un número con hasta 8 dígitos enteros y hasta 2 decimales.',
        ];
    }
}
