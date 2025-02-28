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
            'Fecha_de_nacimiento' => ['required', 'date'],
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
            'Nombre.required'             => 'Nombre obligatorio.',
            'Nombre.regex'                => 'Solo letras y espacios.',
            'Nombre.max'                  => 'Máximo :max caracteres.',
            'Apellido.required'           => 'Apellido obligatorio.',
            'Apellido.regex'              => 'Solo letras y espacios.',
            'Apellido.max'                => 'Máximo :max caracteres.',
            'Vinculo.required'            => 'Vínculo obligatorio.',
            'Vinculo.max'                 => 'Máximo :max caracteres.',
            'Fecha_de_nacimiento.required' => 'Fecha de nacimiento obligatoria.',
            'Fecha_de_nacimiento.date'    => 'Debe ser una fecha válida.',
            'Numero_documento.required'   => 'Número de documento obligatorio.',
            'Numero_documento.unique'     => 'Número de documento en uso.',
            'Numero_documento.digits'     => 'Debe tener :digits dígitos.',
            'Tipo_documento.required'     => 'Tipo de documento obligatorio.',
            'Tipo_documento.regex'        => 'Solo letras.',
            'Lugar_de_trabajo.string'     => 'Debe ser texto.',
            'Lugar_de_trabajo.max'        => 'Máximo :max caracteres.',
            'Ingreso.numeric'             => 'Debe ser un valor numérico.',
            'Ingreso.min'                 => 'No puede ser menor que :min.',
            'Habilitado.required'         => 'Estado obligatorio.',
            'infante_id.required'         => 'Infante obligatorio.',
            'infante_id.exists'           => 'Infante no válido.',
        ];
    }
}
