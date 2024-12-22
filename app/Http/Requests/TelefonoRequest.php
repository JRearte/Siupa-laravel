<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelefonoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Numero'   => ['required', 'integer'],
            'tutor_id' => ['required', 'exists:tutor,id'],
        ];
    }

    public function messages()
    {
        return [
            'Numero.required'   => 'El número de teléfono es obligatorio.',
            'Numero.integer'    => 'El número de teléfono debe ser un número válido.',
            'tutor_id.required' => 'El tutor es obligatorio.',
            'tutor_id.exists'   => 'El tutor seleccionado no es válido.',
        ];
    }
}

