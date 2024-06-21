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
            'Provincia'     => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Localidad'     => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Codigo_postal' => ['required', 'integer', 'digits:4'],
            'Barrio'        => ['required', 'string', 'max:35', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Calle'         => ['required', 'string', 'max:40', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Numero'        => ['required', 'string', 'max:25', 'regex:/^[a-zA-Z0-9 ]+$/'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return[
            'Provincia.required'     => 'La provincia es obligatoria',
            'Provincia.regex'        => 'La provincia solo puede contener letras',
            'Provincia.max'          => 'La provincia solo puede tener un máximo de :max caracteres',
            'Localidad.required'     => 'La localidad es obligatoria',
            'Localidad.regex'        => 'La localidad solo puede contener letras y números',
            'Localidad.max'          => 'La localidad solo puede tener un máximo de :max caracteres',
            'Codigo_postal.required' => 'El código postal es obligatorio',
            'Codigo_postal.integer'  => 'El código postal solo puede contener números enteros',
            'Codigo_postal.digits'   => 'El código postal debe tener :digits dígitos',
            'Barrio.required'        => 'El barrio es obligatorio',
            'Barrio.regex'           => 'El barrio solo puede contener letras y números',
            'Barrio.max'             => 'El barrio solo puede tener un máximo de :max caracteres',
            'Calle.required'         => 'La calle es obligatoria',
            'Calle.regex'            => 'La calle solo puede contener letras y números',
            'Calle.max'              => 'La calle solo puede tener un máximo de :max caracteres',
            'Numero.required'        => 'El número de casa es obligatorio',
            'Numero.regex'           => 'El número de casa puede contener números y letras',
            'Numero.max'             => 'El número de casa puede tener un máximo de :max caracteres',
        ];
    }
}
