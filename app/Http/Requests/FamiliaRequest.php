<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FamiliaRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $id = $this->route('familia');
        return [
            'Nombre'             => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Apellido'           => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Vinculo'            => ['required', 'string', 'max:11', 'in:Padre,Madre,Padrastro,Madrastra,Tío,Tía,Primo,Prima,Hermano,Hermana,Hermanastro,Hermanastra,Abuelo,Abuela'],
            'Fecha_de_nacimiento'=> ['required', 'date'],
            'Numero_documento'   => ['required', 'integer', 'digits:8', Rule::unique('familia', 'Numero_documento')->ignore($id)],
            'Tipo_documento'     => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'],
            'Lugar_de_trabajo'   => ['nullable', 'string', 'max:50'],
            'Ingreso'            => ['nullable', 'numeric', 'min:0'],
            'Habilitado'         => ['required', 'boolean'],
            'infante_id'         => ['required', 'exists:infante,id'],
        ];
    }

    public function messages()
    {
        return [
            'Nombre.required'            => 'El nombre es obligatorio.',
            'Nombre.regex'               => 'El nombre solo puede contener letras y espacios.',
            'Nombre.max'                 => 'El nombre solo puede tener un máximo de :max caracteres.',
            'Apellido.required'          => 'El apellido es obligatorio.',
            'Apellido.regex'             => 'El apellido solo puede contener letras y espacios.',
            'Apellido.max'               => 'El apellido solo puede tener un máximo de :max caracteres.',
            'Vinculo.required'           => 'El vínculo es obligatorio.',
            'Vinculo.max'                => 'El vinculo puede tener un máximo de :max caracteres.',
            'Fecha_de_nacimiento.required'=> 'La fecha de nacimiento es obligatoria.',
            'Fecha_de_nacimiento.date'   => 'La fecha de nacimiento debe ser válida.',
            'Numero_documento.required'  => 'El número de documento es obligatorio.',
            'Numero_documento.unique'    => 'El número de documento ya está en uso.',
            'Numero_documento.digits'    => 'El número de documento debe tener :digits dígitos.',
            'Tipo_documento.required'    => 'El tipo de documento es obligatorio.',
            'Tipo_documento.regex'       => 'El tipo de documento solo puede contener letras.',
            'Lugar_de_trabajo.string'    => 'El lugar de trabajo debe ser texto.',
            'Lugar_de_trabajo.max'       => 'El lugar de trabajo solo puede tener un máximo de :max caracteres.',
            'Ingreso.numeric'            => 'El ingreso debe ser un valor numérico.',
            'Ingreso.min'                => 'El ingreso no puede ser menor que :min.',
            'Habilitado.required'        => 'El estado habilitado es obligatorio.',
            'infante_id.required'        => 'El infante es obligatorio.',
            'infante_id.exists'          => 'El infante seleccionado no es válido.',
        ];
    }
}