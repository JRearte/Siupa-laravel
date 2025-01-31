<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TutorRequest extends FormRequest
{
    /**
     * Determina si el usuario esta autorizado a realizar esta solicitud.
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
        $id = $this->route('tutor');
        return [
            'Legajo'              => ['required', 'string', 'max:13', Rule::unique('tutor', 'Legajo')->ignore($id), 'regex:/^[0-9\/\-]+$/'],
            'Nombre'              => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Apellido'            => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'Genero'              => ['required', 'string', 'max:9', 'in:Masculino,Femenino'],
            'Fecha_de_nacimiento' => ['required', 'date'],
            'Numero_documento'    => ['required', 'integer', 'digits:8', Rule::unique('tutor', 'Numero_documento')->ignore($id)],
            'Tipo_documento'      => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z ]+$/'],
            'Tipo_tutor'          => ['required', 'string', 'max:10', 'in:Trabajador,Alumno'],
            'Habilitado'          => ['boolean'],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages()
    {
        return [
            'Legajo.required'               => 'Legajo obligatorio.',
            'Legajo.max'                    => 'Máx. :max caracteres.',
            'Legajo.unique'                 => 'Ya está en uso.',
            'Legajo.regex'                  => 'Solo números, "-", "/".',
            'Nombre.required'               => 'Nombre obligatorio.',
            'Nombre.regex'                  => 'Solo letras y espacios.',
            'Nombre.max'                    => 'Máximo :max caracteres.',
            'Apellido.required'             => 'Apellido obligatorio.',
            'Apellido.regex'                => 'Solo letras y espacios.',
            'Apellido.max'                  => 'Máximo :max caracteres.',
            'Fecha_de_nacimiento.required'  => 'Fecha obligatoria.',
            'Numero_documento.required'     => 'Documento obligatorio.',
            'Numero_documento.unique'       => 'Ya está en uso.',
            'Numero_documento.digits'       => ':digits dígitos obligatorio.',
            'Numero_documento.integer'      => 'Solo números.',
            'Tipo_documento.required'       => 'Tipo de documento obligatorio.',
            'Tipo_documento.regex'          => 'Solo letras.',
            'Tipo_documento.max'            => 'Máximo :max caracteres.',
        ];
    }
    
}
