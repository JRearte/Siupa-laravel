<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InfanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('infante');
        return [
            'Nombre'             => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Apellido'           => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Genero'             => ['required', 'string', 'max:9', 'in:Masculino,Femenino'],
            'Fecha_de_nacimiento'=> ['required', 'date'],
            'Numero_documento'   => ['required', 'integer', 'digits:8', Rule::unique('infante', 'Numero_documento')->ignore($id)],
            'Tipo_documento'     => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'],
            'Categoria'          => ['required', 'string', 'max:10', 'in:Ingresante,Readmitido'],
            'Fecha_de_asignacion'=> ['required', 'date'],
            'Habilitado'         => ['boolean'],
            'tutor_id'           => ['required', 'exists:tutor,id'],
            'sala_id'            => 'nullable|exists:sala,id',
            
        ];
    }

    public function messages()
    {
        return [
            'Nombre.required'               => 'El nombre es obligatorio.',
            'Nombre.regex'                  => 'El nombre solo puede contener letras y espacios.',
            'Nombre.max'                    => 'El nombre solo puede tener un máximo de :max caracteres.',
            'Apellido.required'             => 'El apellido es obligatorio.',
            'Apellido.regex'                => 'El apellido solo puede contener letras y espacios.',
            'Apellido.max'                  => 'El apellido solo puede tener un máximo de :max caracteres.',
            'Genero.required'               => 'El género es obligatorio.',
            'Genero.in'                     => 'El género debe ser: Masculino o Femenino.',
            'Fecha_de_nacimiento.required'  => 'La fecha de nacimiento es obligatoria.',
            'Fecha_de_nacimiento.date'      => 'La fecha de nacimiento debe ser válida.',
            'Numero_documento.required'     => 'El número de documento es obligatorio.',
            'Numero_documento.unique'       => 'El número de documento ya está en uso.',
            'Numero_documento.digits'       => 'El número de documento debe tener :digits dígitos.',
            'Numero_documento.integer'      => 'Solo números.',
            'Tipo_documento.required'       => 'El tipo de documento es obligatorio.',
            'Tipo_documento.regex'          => 'El tipo de documento solo puede contener letras.',
            'Categoria.required'            => 'La categoría es obligatoria.',
            'Categoria.in'                  => 'La categoría debe ser Ingresante o Readmitido.',
            'Fecha_de_asignacion.required'  => 'La fecha de asignación es obligatoria.',
            'Fecha_de_asignacion.date'      => 'La fecha de asignación debe ser válida.',
            'tutor_id.required'             => 'El tutor es obligatorio.',
            'tutor_id.exists'               => 'El tutor seleccionado no es válido.',
        ];
    }
}