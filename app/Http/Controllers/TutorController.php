<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Correo;
use App\Models\Cuota;
use App\Models\Trabajador;
use App\Models\Carrera;
use App\Models\Asignatura;
use App\Http\Requests\TutorRequest;
use App\Http\Requests\CorreoRequest;
use App\Traits\RegistraHistorial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class TutorController extends Controller
{
    use RegistraHistorial;

    public function listar(): View
    {

        $trabajadores = Tutor::with('infantes')->where('Tipo_tutor', 'Trabajador')->paginate(7, ['*'], 'page_trabajador');
        $alumnos = Tutor::with('infantes')->where('Tipo_tutor', 'Alumno')->paginate(7, ['*'], 'page_alumno');

        return view('tutor.index', compact('trabajadores', 'alumnos'));
    }

    public function presentar(int $id): View
    {
        $tutor = Tutor::with(['domicilio', 'infantes', 'correos', 'telefonos'])->findOrFail($id);
        $edad = Carbon::parse($tutor->Fecha_de_nacimiento)->age;
        $trabajador = null;
        $cuotas = null;
        $carrera = null;
        $asignaturas = null;

        if ($tutor->Tipo_tutor === 'Trabajador') {
            $trabajador = Trabajador::where('tutor_id', $id)->first();

            if ($trabajador) {
                $cuotas = Cuota::where('trabajador_id', $trabajador->id)->get();
                $total = $cuotas->sum('Valor');
            }
        }

        if ($tutor->Tipo_tutor === 'Alumno') {
            $carrera = Carrera::where('tutor_id', $id)->first();
            $asignaturas = Asignatura::where('tutor_id', $id)->get();
        }

        return view('tutor.presentacion', [
            'tutor' => $tutor,
            'edad' => $edad,
            'trabajador' => $trabajador,  // Si es Trabajador, pasamos los datos de trabajador
            'cuotas' => $cuotas,          // Si es Trabajador, pasamos las cuotas
            'total' => $total,
            'infantes' => $tutor->infantes,  // Los infantes del tutor, siempre
            'carrera' => $carrera,        // Si es Alumno, pasamos la carrera
            'asignaturas' => $asignaturas, // Si es Alumno, pasamos las asignaturas
        ]);
    }
}
