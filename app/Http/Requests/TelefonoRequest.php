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
            'Numero.required'   => 'Número obligatorio.',
            'Numero.integer'    => 'Debe ser un número válido.',
            'tutor_id.required' => 'Tutor obligatorio.',
            'tutor_id.exists'   => 'Tutor inválido.',
        ];
    }
    
}

