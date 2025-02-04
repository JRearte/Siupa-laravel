<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Domicilio;
use App\Models\Correo;
use App\Models\Cuota;
use App\Models\Trabajador;
use App\Models\Carrera;
use App\Models\Asignatura;
use App\Http\Requests\TutorRequest;
use App\Http\Requests\DomicilioRequest;
use App\Http\Requests\CorreoRequest;
use App\Http\Requests\TrabajadorRequest;
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

        if ($tutor->Tipo_tutor === 'Trabajador') {
            $this->registrarAccion(auth()->id(), 'Registrar tutor', "Registro al tutor {$tutor->Tipo_tutor} {$tutor->Nombre} {$tutor->Apellido} ");
            return redirect()->route('tutor.agregar-trabajador', $tutor?->id);
        }
        $this->registrarAccion(auth()->id(), 'Registrar tutor', "Registro al tutor {$tutor->Tipo_tutor} {$tutor->Nombre} {$tutor->Apellido} ");
        return redirect()->route('tutor.presentacion', $tutor->id)->with('success', 'El tutor fue registrado exitosamente.');
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
        $tutor = Tutor::findOrFail($id);
        return view('tutor.editar', compact('tutor'));
    }

    /**
     * Este método:
     * → Modifica la información de un tutor en la base de datos con datos validados.
     * → Solo permite la modificación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param TutorRequest $regla → Datos validados del tutor a modificar.
     * @param Tutor $tutor → Objeto tutor con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
     */
    public function modificar(TutorRequest $regla, Tutor $tutor): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar tutores.", "tutor.index");
        $datos = $regla->validated();
        $tutor->update($datos);
        if ($tutor->Tipo_tutor === 'Trabajador') {
            $this->registrarAccion(auth()->id(), 'Modificar tutor', "Modifico al tutor {$tutor->Tipo_tutor} {$tutor->Nombre} {$tutor->Apellido} ");
            return redirect()->route('tutor.editar-trabajador', $tutor?->id);
        }
        $this->registrarAccion(auth()->id(), 'Modificar tutor', "Modifico al tutor {$tutor->Tipo_tutor} {$tutor->Nombre} {$tutor->Apellido} ");
        return redirect()->route('tutor.index')->with('success', 'El tutor fue modificado exitosamente');
    }

    public function advertirEliminacion(int $id): View
    {
        $tutor = Tutor::findOrFail($id);
        return view('tutor.advertencia', compact('tutor'));
    }

    public function eliminar(int $id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar tutores.", "tutor.index");
    
        $tutor = Tutor::findOrFail($id);
        $nombre = $tutor->Nombre;
        $apellido = $tutor->Apellido;
        $ultimoTutor = Tutor::latest('id')->value('id') === $tutor->id;
        $tutor->delete();
        
        if ($ultimoTutor) {
            $this->registrarAccion(auth()->id(), 'Deshacer acción', "Deshizo el registro del tutor {$nombre} {$apellido}");
            return redirect()->route('tutor.index');
        }
    
        $this->registrarAccion(auth()->id(), 'Eliminar tutor', "Eliminó al tutor {$nombre} {$apellido}");
        return redirect()->route('tutor.index')->with('success', 'El tutor fue eliminado exitosamente');
    }
    
    

    /* ==================== Trabajador ==================== */

    /**
     * Este método:
     * → Muestra el formulario para registrar los datos de un trabajador.
     * → Prepara un objeto trabajador vacío con el ID del tutor preasignado.
     *
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return View → Retorna la vista tutor.agregar-trabajador con el objeto trabajador.
     */
    public function formularioRegistrarTrabajador(int $tutor_id): View
    {
        $trabajador = new Trabajador(['tutor_id' => $tutor_id]);
        return view('tutor.agregar-trabajador', compact('trabajador', 'tutor_id'));
    }

    /**
     * Este método:
     * → Registra los datos de un trabajador con validaciones.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     *
     * @param TrabajadorRequest $regla → Datos validados del trabajador a registrar.
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito o error.
     */
    public function registrarTrabajador(TrabajadorRequest $regla, int $tutor_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar datos de trabajador.", "tutor.index");

        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
        Trabajador::create($datos);
        return redirect()->route('tutor.presentacion', ['id' => $tutor_id])->with('success', 'El trabajador fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de un trabajador por el identificador del tutor.
     * → Redirige al formulario de edición con la información del trabajador cargada.
     * 
     * @param int $tutor_id → Identificador único del tutor.
     * @return View → Retorna la vista tutor.editar-trabajador con los datos del trabajador.
     */
    public function formularioModificarTrabajador(int $tutor_id): View
    {
        $trabajador = Trabajador::where('tutor_id', $tutor_id)->firstOrFail();
        return view('tutor.editar-trabajador', compact('trabajador', 'tutor_id'));
    }

    /**
     * Este método:
     * → Modifica la información de un trabajador y su tutor asociado en la base de datos con datos validados.
     * → Solo permite la modificación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param TrabajadorRequest $regla → Datos validados del trabajador a modificar.
     * @param Trabajador $trabajador → Objeto trabajador con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la página de presentación del tutor con un mensaje de éxito o error.
     */
    public function modificarTrabajador(TrabajadorRequest $regla, Trabajador $trabajador): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar trabajadores.", "tutor.index");
        $datos = $regla->validated();
        $trabajador->update($datos);
        return redirect()->route('tutor.presentacion', ['id' => $trabajador->tutor_id])->with('success', 'El trabajador fue modificado exitosamente.');
    }



    /* ==================== Domicilio ==================== */

    /**
     * Este método:
     * → Muestra el formulario para registrar los datos de un domicilio.
     * → Prepara un objeto domicilio vacío con el ID del tutor preasignado.
     *
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return View → Retorna la vista tutor.agregar-domicilio con el objeto domicilio.
     */
    public function formularioRegistrarDomicilio(int $tutor_id): View
    {
        $domicilio = new Domicilio(['tutor_id' => $tutor_id]);
        return view('tutor.agregar-domicilio', compact('domicilio', 'tutor_id'));
    }

    /**
     * Este método:
     * → Registra los datos de un domicilio con validaciones.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     *
     * @param DomicilioRequest $regla → Datos validados del domicilio a registrar.
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito o error.
     */
    public function registrarDomicilio(DomicilioRequest $regla, int $tutor_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar datos de domicilio.", "tutor.index");

        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
        Domicilio::create($datos);

        $tutor = Tutor::findOrFail($tutor_id);
        $this->registrarAccion(auth()->id(), 'Registrar domicilio', "Registró los datos del domicilio de {$tutor->Nombre} {$tutor->Apellido}");

        return redirect()->route('tutor.presentacion', ['id' => $tutor_id])->with('success', 'El domicilio fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de un domicilio por el identificador del tutor.
     * → Redirige al formulario de edición con la información del domicilio cargada.
     *
     * @param int $tutor_id → Identificador único del tutor.
     * @return View → Retorna la vista tutor.editar-domicilio con los datos del domicilio.
     */
    public function formularioModificarDomicilio(int $tutor_id): View
    {
        $domicilio = Domicilio::where('tutor_id', $tutor_id)->firstOrFail();
        return view('tutor.editar-domicilio', compact('domicilio', 'tutor_id'));
    }

    /**
     * Este método:
     * → Modifica la información de un domicilio y su tutor asociado en la base de datos con datos validados.
     * → Solo permite la modificación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     *
     * @param DomicilioRequest $regla → Datos validados del domicilio a modificar.
     * @param Domicilio $domicilio → Objeto domicilio con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la página de presentación del tutor con un mensaje de éxito o error.
     */
    public function modificarDomicilio(DomicilioRequest $regla, Domicilio $domicilio): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar domicilios.", "tutor.index");
        $datos = $regla->validated();
        $domicilio->update($datos);
        $tutor = Tutor::findOrFail($domicilio->tutor_id);
        $this->registrarAccion(auth()->id(), 'Modificar domicilio', "Modificó el domicilio de {$tutor->Nombre} {$tutor->Apellido}");

        return redirect()->route('tutor.presentacion', ['id' => $tutor->id])->with('success', 'El domicilio fue modificado exitosamente.');
    }
}
