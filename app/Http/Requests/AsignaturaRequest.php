<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignaturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Codigo'       => ['required', 'integer', 'digits_between:3,4'],
            'Nombre'       => ['required', 'string', 'max:90', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Fecha'        => ['required', 'date'],
            'Condicion'    => ['required', 'string', 'in:Cursando,Libre,Regular,Aprobado'],
            'Calificacion' => ['required', 'integer', 'between:0,10'],
            'tutor_id'     => ['required', 'exists:tutor,id'],
            'carrera_id'   => ['required', 'exists:carrera,id'],
        ];
    }

    public function messages()
    {
        return [
            'Codigo.required'       => 'Código obligatorio.',
            'Codigo.integer'        => 'Debe ser un número entero.',
            'Codigo.digits_between' => 'Debe tener entre :min y :max dígitos.',
            'Nombre.required'       => 'Nombre obligatorio.',
            'Nombre.regex'          => 'Solo puede contener letras y espacios.',
            'Nombre.max'            => 'Máximo :max caracteres.',
            'Fecha.required'        => 'Fecha obligatoria.',
            'Fecha.date'            => 'Fecha no válida.',
            'Condicion.required'    => 'Condición obligatoria.',
            'Condicion.in'          => 'Debe ser: Cursando, Libre, Regular o Aprobado.',
            'Calificacion.required' => 'Calificación obligatoria.',
            'Calificacion.integer'  => 'Debe ser un número entero.',
            'Calificacion.between'  => 'Debe estar entre :min y :max.',
            'tutor_id.required'     => 'Tutor obligatorio.',
            'tutor_id.exists'       => 'Tutor no válido.',
            'carrera_id.required'   => 'Carrera obligatoria.',
            'carrera_id.exists'     => 'Carrera no válida.',
        ];
    }
}
