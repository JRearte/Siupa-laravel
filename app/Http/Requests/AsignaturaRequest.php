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
            'Codigo.required'        => 'El código de la asignatura es obligatorio.',
            'Codigo.integer'         => 'El código de la asignatura debe ser un número entero.',
            'Codigo.digits_between'  => 'El código de la asignatura debe tener entre :min y :max dígitos.',
            'Nombre.required'        => 'El nombre de la asignatura es obligatorio.',
            'Nombre.regex'           => 'El nombre solo puede contener letras y espacios.',
            'Nombre.max'             => 'El nombre puede tener un máximo de :max caracteres.',
            'Fecha.required'         => 'La fecha de la asignatura es obligatoria.',
            'Fecha.date'             => 'La fecha debe ser válida.',
            'Condicion.required'     => 'La condición es obligatoria.',
            'Condicion.in'           => 'La condición debe ser uno de los valores permitidos: Cursando, Libre, Regular, Aprobado.',
            'Calificacion.required'  => 'La calificación es obligatoria.',
            'Calificacion.integer'   => 'La calificación debe ser un número entero.',
            'Calificacion.between'   => 'La calificación debe estar entre :min y :max.',
            'tutor_id.required'      => 'El tutor asociado es obligatorio.',
            'tutor_id.exists'        => 'El tutor seleccionado no es válido.',
            'carrera_id.required'    => 'La carrera asociada es obligatoria.',
            'carrera_id.exists'      => 'La carrera seleccionada no es válida.',
        ];
    }
}