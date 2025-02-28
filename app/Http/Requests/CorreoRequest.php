<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorreoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Mail'      => ['required', 'email', 'max:45'],
            'tutor_id'  => ['required', 'exists:tutor,id'],
        ];
    }

    public function messages()
    {
        return [
            'Mail.required'     => 'Correo obligatorio.',
            'Mail.email'        => 'Debe contener "@".',
            'Mail.max'          => 'Máximo :max caracteres.',
            'tutor_id.required' => 'Tutor obligatorio.',
            'tutor_id.exists'   => 'Tutor no válido.',
        ];
    }    
}