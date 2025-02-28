<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomicilioRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'Provincia'     => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/'],
            'Localidad'     => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/'],
            'Codigo_postal' => ['required', 'integer', 'digits:4'],
            'Barrio'        => ['required', 'string', 'max:35', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/'],
            'Calle'         => ['required', 'string', 'max:40', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+$/'],
            'Numero'        => ['required', 'string', 'max:25', 'regex:/^[a-zA-Z0-9 ]+$/'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'Provincia.required'     => 'Provincia obligatoria.',
            'Provincia.regex'        => 'Solo letras y números.',
            'Provincia.max'          => 'Máximo :max caracteres.',
            'Localidad.required'     => 'Localidad obligatoria.',
            'Localidad.regex'        => 'Solo letras y números.',
            'Localidad.max'          => 'Máximo :max caracteres.',
            'Codigo_postal.required' => 'Código postal obligatorio.',
            'Codigo_postal.integer'  => 'Solo números enteros.',
            'Codigo_postal.digits'   => 'Debe tener :digits dígitos.',
            'Barrio.required'        => 'Barrio obligatorio.',
            'Barrio.regex'           => 'Solo letras y números.',
            'Barrio.max'             => 'Máximo :max caracteres.',
            'Calle.required'         => 'Calle obligatoria.',
            'Calle.regex'            => 'Solo letras y números.',
            'Calle.max'              => 'Máximo :max caracteres.',
            'Numero.required'        => 'Número obligatorio.',
            'Numero.regex'           => 'Puede contener números y letras.',
            'Numero.max'             => 'Máximo :max caracteres.',
        ];
    }    
}
