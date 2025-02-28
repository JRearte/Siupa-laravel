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
            'Nombre.required'               => 'Nombre obligatorio.',
            'Nombre.regex'                  => 'Solo letras y espacios.',
            'Nombre.max'                    => 'Máximo :max caracteres.',
            'Apellido.required'             => 'Apellido obligatorio.',
            'Apellido.regex'                => 'Solo letras y espacios.',
            'Apellido.max'                  => 'Máximo :max caracteres.',
            'Genero.required'               => 'Género obligatorio.',
            'Genero.in'                     => 'Debe ser Masculino o Femenino.',
            'Fecha_de_nacimiento.required'  => 'Fecha de nacimiento obligatoria.',
            'Fecha_de_nacimiento.date'      => 'Debe ser una fecha válida.',
            'Numero_documento.required'     => 'Número de documento obligatorio.',
            'Numero_documento.unique'       => 'Número de documento en uso.',
            'Numero_documento.digits'       => 'Debe tener :digits dígitos.',
            'Numero_documento.integer'      => 'Solo números.',
            'Tipo_documento.required'       => 'Tipo de documento obligatorio.',
            'Tipo_documento.regex'          => 'Solo letras.',
            'Categoria.required'            => 'Categoría obligatoria.',
            'Categoria.in'                  => 'Debe ser Ingresante o Readmitido.',
            'Fecha_de_asignacion.required'  => 'Fecha de asignación obligatoria.',
            'Fecha_de_asignacion.date'      => 'Debe ser una fecha válida.',
            'tutor_id.required'             => 'Tutor obligatorio.',
            'tutor_id.exists'               => 'Tutor no válido.',
        ];
    }
    
}