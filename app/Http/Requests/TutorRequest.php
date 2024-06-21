<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Validation\Rule;

class TutorRequest extends FormRequest
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
        $id = $this->route('tutor');
        return [
            'Legajo'              => ['required', 'string', 'size:13', Rule::unique('tutor', 'Legajo')->ignore($id), 'regex:/^[0-9\/\-]+$/'],
            'Nombre'              => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Apellido'            => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Genero'              => ['required', 'string', 'max:9', 'in:Masculino,Femenino'],
            'Fecha_de_nacimiento' => ['required', 'date'],
            'Numero_documento'    => ['required', 'integer', 'digits:8', Rule::unique('tutor', 'Numero_documento')->ignore($id)],
            'Tipo_documento'      => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'],
            'Tipo_tutor'          => ['required', 'string', 'max:10', 'in:Docente,No docente'],
            'Habilitado'          => ['boolean'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'Legajo.required'           => 'El legajo es obligatorio.',
            'Legajo.size'               => 'El legajo debe tener :size caracteres.',
            'Legajo.unique'             => 'El legajo ya está en uso.',
            'Legajo.regex'              => 'El legajo solo puede contener números y los símbolos "-","/"',
            'Nombre.required'           => 'El nombre es obligatorio.',
            'Nombre.regex'              => 'El nombre solo puede contener letras y espacios.',
            'Nombre.max'                => 'El nombre solo puede tener un máximo de :max caracteres.',
            'Apellido.required'         => 'El apellido es obligatorio.',
            'Apellido.regex'            => 'El apellido solo puede contener letras y espacios.',
            'Apellido.max'              => 'El apellido solo puede tener un máximo de :max caracteres.',
            'Numero_documento.required' => 'El número de documento es obligatorio.',
            'Numero_documento.unique'   => 'El número de documento ya esta en uso',
            'Numero_documento.digits'   => 'El número de documento debe tener :digits dígitos.',
            'Numero_documento.integer'  => 'El número de documento solo puede tener números enteros',
            'Tipo_documento.required'   => 'El tipo de documento es obligatorio.',
            'Tipo_documento.regex'      => 'El tipo de documento solo puede contener letras.',
            'Tipo_documento.max'        => 'El tipo de documento puede tener un máximo de :max caracteres.',
        ];
    }
}
