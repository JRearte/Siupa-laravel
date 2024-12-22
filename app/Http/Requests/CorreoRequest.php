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
            'Mail.required'       => 'El correo electrónico es obligatorio.',
            'Mail.email'          => 'El correo electrónico debe ser válido.',
            'Mail.max'            => 'El correo electrónico no puede tener más de :max caracteres.',
            'tutor_id.required'   => 'El tutor es obligatorio.',
            'tutor_id.exists'     => 'El tutor seleccionado no es válido.',
        ];
    }
}