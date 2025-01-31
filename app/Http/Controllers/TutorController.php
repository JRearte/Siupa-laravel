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
        $trabajadores = Tutor::with('infantes')->where('Tipo_tutor', 'Trabajador')->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_trabajador');
        $alumnos = Tutor::with('infantes')->where('Tipo_tutor', 'Alumno')->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_alumno');
        return view('tutor.index', compact('trabajadores', 'alumnos'));
    }


    /**
     * Este método:
     * → Recupera la información detallada de un tutor por su identificador único.
     * → Calcula la edad a través de su fecha de nacimiento.
     * → Calcula el total de las cuotas registradas.
     * 
     * @param int $id → Identificador único del tutor.
     * @return View → Retorna la vista tutor.presentacion con los datos del tutor.
     */
    public function presentar(int $id): View
    {
        $tutor = Tutor::with(['domicilio', 'infantes', 'correos', 'telefonos'])->findOrFail($id);
        $edad = Carbon::parse($tutor->Fecha_de_nacimiento)->age;
        $trabajador = null;
        $cuotas = null;
        $total = 0;
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
            'trabajador' => $trabajador,
            'cuotas' => $cuotas,
            'total' => $total,
            'infantes' => $tutor->infantes,
            'carrera' => $carrera,
            'asignaturas' => $asignaturas
        ]);
    }


    /**
     * Este método:
     * → Muestra el formulario para registrar un nuevo tutor.
     * → Prepara un objeto tutor vacío para su carga inicial.
     * 
     * @return View → Retorna la vista tutor.agregar con el objeto tutor.
     */
    public function formularioRegistrar(): View
    {
        $tutor = new Tutor();
        return view('tutor.agregar', compact('tutor'));
    }


    /**
     * Este método:
     * → Registra un nuevo tutor en la base de datos con datos validados.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param TutorRequest $regla → Datos validados del tutor a registrar.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
     */
    public function registrar(TutorRequest $regla): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar tutores.", "tutor.index");
        $datos = $regla->validated();
        $tutor = Tutor::create($datos);
        $this->registrarAccion(auth()->id(), 'Registrar tutor', "Registro el tutor {$tutor->Nombre} {$tutor->Apellido} ");
        return redirect()->route('tutor.index')->with('success', 'El tutor fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de un tutor por su identificador único.
     * → Redirige al formulario de edición con la información del tutor cargada.
     * 
     * @param int $id → Identificador único del tutor.
     * @return View → Retorna la vista tutor.editar con los datos del tutor.
     */
    public function formularioModificar(int $id): View
    {
        $tutor = Tutor::find($id);
        return view('tutor.editar', compact('tutor'));
    }

    /**
     * Este método:
     * → Modifica la información de un tutor en la base de datos con datos validados.
     * → Solo permite la modificación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param UsuarioRequest $regla → Datos validados del tutor a modificar.
     * @param Usuario $tutor → Objeto tutor con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
     */
    public function modificar(TutorRequest $regla, Tutor $tutor): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar tutores.", "tutor.index");
        $datos = $regla->validated();
        $tutor->update($datos);
        $this->registrarAccion(auth()->id(), 'Modificar tutor', "Modifico el tutor {$tutor->Nombre} {$tutor->Apellido} ");
        return redirect()->route('tutor.index')->with('success', 'El tutor fue modificado exitosamente');
    }
}
