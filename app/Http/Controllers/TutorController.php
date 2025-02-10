<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Domicilio;
use App\Models\Telefono;
use App\Models\Correo;
use App\Models\Cuota;
use App\Models\Trabajador;
use App\Models\Carrera;
use App\Models\Asignatura;
use App\Http\Requests\TutorRequest;
use App\Http\Requests\DomicilioRequest;
use App\Http\Requests\TelefonoRequest;
use App\Http\Requests\CorreoRequest;
use App\Http\Requests\CarreraRequest;
use App\Http\Requests\AsignaturaRequest;
use App\Http\Requests\CuotaRequest;
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
        $tutor = Tutor::with(['domicilio', 'infantes.sala', 'correos', 'telefonos'])->findOrFail($id);
        $edad = Carbon::parse($tutor->Fecha_de_nacimiento)->age;
        $trabajador = null;
        $cuotas = null;
        $total = 0;
        $carrera = null;
        $asignaturas = null;
        $porcentaje = 0;

        if ($tutor->Tipo_tutor === 'Trabajador') {
            $trabajador = Trabajador::where('tutor_id', $id)->first();

            if ($trabajador) {
                $cuotas = Cuota::where('trabajador_id', $trabajador->id)->orderBy('Fecha', 'asc')->get();
                $total = $cuotas->sum('Valor');
            }
        }

        if ($tutor->Tipo_tutor === 'Alumno') {
            $carrera = Carrera::where('tutor_id', $id)->first();
            $asignaturas = Asignatura::where('tutor_id', $id)->get();
            $condicion = $asignaturas->whereIn('Condicion', ['Regular', 'Aprobado'])->count();
            $totalAsignaturas = $asignaturas->count();
            $porcentaje = $totalAsignaturas > 0 ? ($condicion / $totalAsignaturas) * 100 : 0;
        }

        return view('tutor.presentacion', [
            'tutor' => $tutor,
            'edad' => $edad,
            'trabajador' => $trabajador,
            'cuotas' => $cuotas,
            'total' => $total,
            'infantes' => $tutor->infantes,
            'carrera' => $carrera,
            'asignaturas' => $asignaturas,
            'porcentaje' => $porcentaje
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
            $this->registrarAccion(auth()->id(), 'Registrar tutor trabajador', "Registro al tutor {$tutor->Tipo_tutor} {$tutor->Nombre} {$tutor->Apellido} ");
            return redirect()->route('tutor.agregar-trabajador', $tutor?->id);
        } else {
            $this->registrarAccion(auth()->id(), 'Registrar tutor alumno', "Registro al tutor {$tutor->Tipo_tutor} {$tutor->Nombre} {$tutor->Apellido} ");
            return redirect()->route('tutor.agregar-carrera', $tutor?->id);
        }
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
            $trabajador = Trabajador::where('tutor_id', $tutor->id)->exists();

            if ($trabajador) {
                return redirect()->route('tutor.editar-trabajador', $tutor->id);
            }
            return redirect()->route('tutor.agregar-trabajador', $tutor->id);
        } else {
            $carrera = Carrera::where('tutor_id', $tutor->id)->exists();

            if ($carrera) {
                return redirect()->route('tutor.editar-carrera', $tutor->id);
            }
            return redirect()->route('tutor.agregar-carrera', $tutor->id);
        }
    }

    /**
     * Este método:
     * → Muestra una advertencia antes de eliminar un tutor.
     *
     * @param int $id → Identificador unico del tutor.
     * @return View → Retorna la vista tutor.advertencia con los datos del tutor.
     */
    public function advertirEliminacion(int $id): View
    {
        $tutor = Tutor::findOrFail($id);
        return view('tutor.advertencia', compact('tutor'));
    }

    /**
     * Este método:
     * → Elimina a un tutor.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     *
     * @param int $id → Identificador unico del tutor a eliminar.
     * @return RedirectResponse → Redirige a la página principal de tutores con un mensaje de éxito o sin mensaje si se deshizo la acción.
     */
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

    /* ==================== Contacto ==================== */

    /**
     * Este método:
     * → Muestra el formulario para registrar un nuevo teléfono asociado a un tutor.
     * → Prepara un objeto teléfono vacío con el tutor asignado para su carga inicial.
     * 
     * @param int $tutor_id → Identificador único del tutor al que se asociará el teléfono.
     * @return View → Retorna la vista tutor.formulario-telefono con el objeto teléfono y el tutor_id.
     */
    public function formularioRegistrarTelefono($tutor_id): View
    {
        $telefono = new Telefono(['tutor_id' => $tutor_id]);
        return view('tutor.formulario-telefono', compact('telefono', 'tutor_id'));
    }

    /**
     * Este método:
     * → Registra un nuevo teléfono en la base de datos con datos validados.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param TelefonoRequest $regla → Datos validados del teléfono a registrar.
     * @param int $tutor_id → Identificador único del tutor al que se asociará el teléfono.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function registrarTelefono(TelefonoRequest $regla, int $tutor_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar contactos.", "tutor.index");
        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
        Telefono::create($datos);
        $tutor = Tutor::findOrFail($tutor_id);
        $this->registrarAccion(auth()->id(), 'Registrar teléfono', "Registró contacto del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', ['id' => $tutor_id])->with('success', 'El teléfono fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Elimina un teléfono registrado en la base de datos.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     *
     * @param int $id → Identificador único del teléfono a eliminar.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function eliminarTelefono(int $id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar contactos.", "tutor.index");
        $telefono = Telefono::findOrFail($id);
        $tutor = Tutor::findOrFail($telefono->tutor_id);
        $telefono->delete();
        $this->registrarAccion(auth()->id(), 'Eliminar teléfono', "Eliminó un contacto del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor->id)->with('success', 'El teléfono fue eliminado exitosamente');
    }

    /**
     * Este método:
     * → Muestra el formulario para registrar un nuevo correo electrónico asociado a un tutor.
     * → Prepara un objeto correo vacío con el tutor asignado para su carga inicial.
     * 
     * @param int $tutor_id → Identificador único del tutor al que se asociará el correo.
     * @return View → Retorna la vista tutor.formulario-correo con el objeto correo y el tutor_id.
     */
    public function formularioRegistrarCorreo($tutor_id): View
    {
        $correo = new Correo(['tutor_id' => $tutor_id]);
        return view('tutor.formulario-correo', compact('correo', 'tutor_id'));
    }

    /**
     * Este método:
     * → Registra un nuevo correo electrónico en la base de datos con datos validados.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param CorreoRequest $regla → Datos validados del correo a registrar.
     * @param int $tutor_id → Identificador único del tutor al que se asociará el correo.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function registrarCorreo(CorreoRequest $regla, int $tutor_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar contactos.", "tutor.index");
        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
        Correo::create($datos);
        $tutor = Tutor::findOrFail($tutor_id);
        $this->registrarAccion(auth()->id(), 'Registrar correo', "Registró contacto del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', ['id' => $tutor_id])->with('success', 'El correo fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Elimina un correo registrado en la base de datos.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     *
     * @param int $id → Identificador único del correo a eliminar.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function eliminarCorreo(int $id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar contactos.", "tutor.index");
        $correo = Correo::findOrFail($id);
        $tutor = Tutor::findOrFail($correo->tutor_id);
        $correo->delete();
        $this->registrarAccion(auth()->id(), 'Eliminar correo', "Eliminó un contacto del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor->id)->with('success', 'El correo fue eliminado exitosamente');
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

    /* ==================== Cuota ==================== */

    /**
     * Este método:
     * → Muestra el formulario para registrar una nueva cuota de un trabajador.
     * 
     * @param int $tutor_id → Identificador único del tutor.
     * @return View → Retorna la vista tutor.formulario-cuota con el objeto cuota y el ID del trabajador.
     */
    public function formularioRegistrarCuota(int $tutor_id)
    {
        $trabajador = Trabajador::where('tutor_id', $tutor_id)->first();

        if (!$trabajador) {
            return redirect()->route('tutor.presentacion', $tutor_id)->with('error', 'Termine de completar los datos del tutor.');
        }

        $cuota = new Cuota(['trabajador_id' => $trabajador->id]);
        return view('tutor.formulario-cuota', compact('cuota', 'trabajador'));
    }


    /**
     * Este método:
     * → Registra una nueva cuota de un trabajador en la base de datos.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param CuotaRequest $regla → Datos validados de la cuota a registrar.
     * @param int $trabajador_id → Identificador único del trabajador asociado a la cuota.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function registrarCuota(CuotaRequest $regla, int $trabajador_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar cuotas.", "tutor.index");
        $datos = $regla->validated();
        $datos['trabajador_id'] = $trabajador_id;
        $trabajador = Trabajador::where('id', $trabajador_id)->firstOrFail();
        $tutor = Tutor::where('id', $trabajador->tutor_id)->firstOrFail();
        Cuota::create($datos);
        $this->registrarAccion(auth()->id(), 'Registrar cuota', "Registró la cuota del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $trabajador->tutor_id)->with('success', 'La cuota fue registrada exitosamente.');
    }

    /**
     * Este método:
     * → Elimina una cuota de un tutor trabajador.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     * 
     * @param int $tutor_id → Identificador único del tutor al que pertenece la cuota.
     * @param int $id → Identificador único de la cuota a eliminar.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function eliminarCuota(int $tutor_id, int $id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar cuotas.", "tutor.index");
        $cuota = Cuota::findOrFail($id);
        $tutor = Tutor::findOrFail($tutor_id);
        $fecha = $cuota->Fecha->translatedFormat('d F Y');
        $cuota->delete();
        $this->registrarAccion(auth()->id(), 'Eliminar cuota', "Eliminó la cuota creada el {$fecha} del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor->id)->with('success', 'La cuota fue eliminada exitosamente');
    }

    /* ==================== Carrera ==================== */

    /**
     * Este método:
     * → Muestra el formulario para registrar una carrera.
     * → Prepara un objeto carrera vacío con el ID del tutor preasignado.
     *
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return View → Retorna la vista tutor.agregar-carrera con el objeto carrera.
     */
    public function formularioRegistrarCarrera(int $tutor_id): View
    {
        $carrera = new Carrera(['tutor_id' => $tutor_id]);
        return view('tutor.agregar-carrera', compact('carrera', 'tutor_id'));
    }

    /**
     * Este método:
     * → Registra los datos de una carrera con validaciones.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     *
     * @param CarreraRequest $regla → Datos validados de la carrera a registrar.
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito o error.
     */
    public function registrarCarrera(CarreraRequest $regla, int $tutor_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar carrera.", "tutor.index");
        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
        Carrera::create($datos);
        return redirect()->route('tutor.presentacion', $tutor_id)->with('success', 'La carrera fue registrada exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de una carrera por el identificador del tutor.
     * → Redirige al formulario de edición con la información de la carrera cargada.
     *
     * @param int $tutor_id → Identificador único del tutor.
     * @return View → Retorna la vista tutor.editar-carrera con los datos de la carrera.
     */
    public function formularioModificarCarrera(int $tutor_id): View
    {
        $carrera = Carrera::where('tutor_id', $tutor_id)->firstOrFail();
        return view('tutor.editar-carrera', compact('carrera', 'tutor_id'));
    }

    /**
     * Este método:
     * → Modifica la información de una carrera en la base de datos con datos validados.
     * → Solo permite la modificación a usuarios con categoría "Bienestar".
     *
     * @param CarreraRequest $regla → Datos validados de la carrera a modificar.
     * @param Carrera $carrera → Objeto carrera con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la página de presentación del tutor con un mensaje de éxito o error.
     */
    public function modificarCarrera(CarreraRequest $regla, Carrera $carrera): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar carreras.", "tutor.index");
        $datos = $regla->validated();
        $carrera->update($datos);
        return redirect()->route('tutor.presentacion', ['id' => $carrera->tutor_id])->with('success', 'La carrera fue modificada exitosamente.');
    }

    /* ==================== Asignatura ==================== */

    public function formularioRegistrarAsignatura(int $tutor_id, int $carrera_id): View|RedirectResponse
    {
        $carrera = Carrera::where('tutor_id', $tutor_id)->where('id', $carrera_id)->first();
        if (!$carrera) {
            return redirect()->route('tutor.presentacion', $tutor_id)->with('error', 'Termine de completar los datos del tutor.');
        }
        $asignatura = new Asignatura(['tutor_id' => $tutor_id, 'carrera_id' => $carrera_id]);
        return view('tutor.agregar-asignatura', compact('asignatura', 'tutor_id', 'carrera_id'));
    }


    public function registrarAsignatura(AsignaturaRequest $regla, int $tutor_id, int $carrera_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar asignaturas.", "tutor.index");
        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
        $datos['carrera_id'] = $carrera_id;
        $tutor = Tutor::findOrFail($tutor_id);
        Asignatura::create($datos);
        $this->registrarAccion(auth()->id(), 'Registrar asignatura', "Registro la asignatura del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor_id)->with('success', 'La asignatura fue registrada exitosamente.');
    }

    public function formularioModificarAsignatura(int $carrera_id, int $asignatura_id): View
    {
        $asignatura = Asignatura::where('id', $asignatura_id)->where('carrera_id', $carrera_id)->firstOrFail();
        $tutor_id = $asignatura->tutor_id;
        return view('tutor.editar-asignatura', compact('asignatura', 'carrera_id', 'tutor_id'));
    }


    public function modificarAsignatura(AsignaturaRequest $regla, Asignatura $asignatura): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar asignaturas.", "tutor.index");
        $datos = $regla->validated();
        $asignatura->update($datos);
        $tutor = Tutor::findOrFail($asignatura->tutor_id);
        $this->registrarAccion(auth()->id(), 'Modificar asignatura', "Modificó la asignatura del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', ['id' => $tutor->id])->with('success', 'La asignatura fue modificada exitosamente.');
    }

    public function eliminarAsignatura(int $tutor_id, int $id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar asignaturas.", "tutor.index");
        $asignatura = Asignatura::findOrFail($id);
        $tutor = Tutor::findOrFail($tutor_id);
        $asignatura->delete();
        $this->registrarAccion(auth()->id(), 'Eliminar asignatura', "Eliminó la asignatura {$asignatura->Nombre} del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor->id)->with('success', 'La asignatura fue eliminada exitosamente');
    }
}
