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
use App\Models\Infante;
use App\Models\Familia;
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

    public function listar(Request $request): View
    {
        $buscar = $request->input('buscar');
        $datos = [];
    
        // ==================== Filtro de Trabajadores ====================
        $trabajadores = Tutor::with('infantes')
            ->where('Tipo_tutor', 'Trabajador');
    
        if ($buscar) {
            $trabajadores->where(function ($query) use ($buscar) {
                $query->where('Legajo', 'LIKE', "%$buscar%")
                    ->orWhere('Nombre', 'LIKE', "%$buscar%")
                    ->orWhere('Apellido', 'LIKE', "%$buscar%");
            });
        }
    
        $datos['trabajadores'] = $trabajadores->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_trabajador');
        $datos['trabajadores']->appends(['buscar' => $buscar]);
    
        // ==================== Filtro de Alumnos ====================
        $alumnos = Tutor::with('infantes')
            ->where('Tipo_tutor', 'Alumno');
    
        if ($buscar) {
            $alumnos->where(function ($query) use ($buscar) {
                $query->where('Legajo', 'LIKE', "%$buscar%")
                    ->orWhere('Nombre', 'LIKE', "%$buscar%")
                    ->orWhere('Apellido', 'LIKE', "%$buscar%");
            });
        }
    
        $datos['alumnos'] = $alumnos->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_alumno');
        $datos['alumnos']->appends(['buscar' => $buscar]);
    
        $trabajadores = $datos['trabajadores'] ?? null;
        $alumnos = $datos['alumnos'] ?? null;
    
        return view('tutor.index', compact('trabajadores', 'alumnos', 'buscar'));
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
        $this->validarPermiso(["Bienestar"], "No tienes permiso para ver tutores.", "tutor.index");
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
        $this->validarPermiso(["Bienestar"], "No tienes permiso para registrar tutores.", "tutor.index");
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
        $this->validarPermiso(["Bienestar"], "No tienes permiso para registrar tutores.", "tutor.index");
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar tutores.", "tutor.presentacion", $id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar tutores.", "tutor.presentacion", $tutor->id);
        $datos = $regla->validated();
        $tutor->update($datos);

        if ($tutor->Habilitado == 0) {
            $infantes = Infante::where('tutor_id', $tutor->id)->get();

            foreach ($infantes as $infante) {
                $infante->Habilitado = 0;
                $infante->save();

                Familia::where('infante_id', $infante->id)->update(['Habilitado' => 0]);
            }
        } else {
            $infantes = Infante::where('tutor_id', $tutor->id)->get();

            foreach ($infantes as $infante) {
                $infante->Habilitado = 1;
                $infante->save();

                Familia::where('infante_id', $infante->id)->update(['Habilitado' => 1]);
            }
        }


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
     * → Elimina a un tutor.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial.
     *
     * @param int $id → Identificador unico del tutor a eliminar.
     * @return RedirectResponse → Redirige a la página principal de tutores con un mensaje de éxito o sin mensaje si se deshizo la acción.
     */
    public function eliminar(int $id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar tutores.", "tutor.presentacion", $id);

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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar contactos.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar contactos.", "tutor.presentacion", $tutor_id);
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
        $telefono = Telefono::with('tutor')->findOrFail($id);
        $tutor = $telefono->tutor;
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar contactos.", "tutor.presentacion", $tutor->id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar contactos.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar contactos.", "tutor.presentacion", $tutor_id);
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
        $correo = Correo::with('tutor')->findOrFail($id);
        $tutor = $correo->tutor;
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar contactos.", "tutor.presentacion", $tutor->id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar domicilio.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar domicilio.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar domicilio.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar domicilio.", "tutor.presentacion", $domicilio->tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar trabajador.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar trabajador.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar trabajador.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar trabajador.", "tutor.presentacion", $trabajador->tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar cuotas.", "tutor.presentacion", $tutor_id);
        $trabajador = Trabajador::where('tutor_id', $tutor_id)->first();

        if (!$trabajador) {
            return redirect()->route('tutor.presentacion', $tutor_id)->with('info', 'Termine de completar los datos del tutor.');
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
        $trabajador = Trabajador::with('tutor')->findOrFail($trabajador_id);
        $tutor = $trabajador->tutor;
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar cuotas.", "tutor.presentacion", $tutor->id);
        $datos = $regla->validated();
        $datos['trabajador_id'] = $trabajador_id;
        Cuota::create($datos);
        $this->registrarAccion(auth()->id(), 'Registrar cuota', "Registró la cuota del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor->id)->with('success', 'La cuota fue registrada exitosamente.');
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar cuotas.", "tutor.presentacion", $tutor_id);
        $cuota = Cuota::with('trabajador.tutor')->findOrFail($id);
        $tutor = $cuota->trabajador->tutor;
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar carrera.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar carrera.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar carrera.", "tutor.presentacion", $tutor_id);
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
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar carrera.", "tutor.presentacion", $carrera->tutor_id);
        $datos = $regla->validated();
        $carrera->update($datos);
        return redirect()->route('tutor.presentacion', ['id' => $carrera->tutor_id])->with('success', 'La carrera fue modificada exitosamente.');
    }

    /* ==================== Asignatura ==================== */

    /**
     * Este método:
     * → Muestra el formulario para registrar una asignatura.
     * → Verifica que la carrera asociada al tutor exista antes de permitir el registro.
     *
     * @param int $tutor_id → Identificador del tutor asociado.
     * @param int $carrera_id → Identificador de la carrera asociada.
     * @return View|RedirectResponse → Retorna la vista de agregar asignatura o redirige si la carrera no existe.
     */
    public function formularioRegistrarAsignatura(int $tutor_id, int $carrera_id): View|RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar asignaturas.", "tutor.presentacion", $tutor_id);
        $carrera = Carrera::where('tutor_id', $tutor_id)->where('id', $carrera_id)->first();
        if (!$carrera) {
            return redirect()->route('tutor.presentacion', $tutor_id)->with('error', 'Termine de completar los datos del tutor.');
        }
        $asignatura = new Asignatura(['tutor_id' => $tutor_id, 'carrera_id' => $carrera_id]);
        return view('tutor.agregar-asignatura', compact('asignatura', 'tutor_id', 'carrera_id'));
    }


    /**
     * Este método:
     * → Registra una asignatura con validaciones previas.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param AsignaturaRequest $regla → Datos validados de la asignatura a registrar.
     * @param int $tutor_id → Identificador del tutor asociado.
     * @param int $carrera_id → Identificador de la carrera asociada.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function registrarAsignatura(AsignaturaRequest $regla, int $tutor_id, int $carrera_id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar asignaturas.", "tutor.presentacion", $tutor_id);
        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
        $datos['carrera_id'] = $carrera_id;
        $tutor = Tutor::findOrFail($tutor_id);
        Asignatura::create($datos);
        $this->registrarAccion(auth()->id(), 'Registrar asignatura', "Registro la asignatura del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor_id)->with('success', 'La asignatura fue registrada exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de una asignatura por su identificador y el de su carrera.
     * → Redirige al formulario de edición con la información cargada.
     *
     * @param int $carrera_id → Identificador único de la carrera.
     * @param int $asignatura_id → Identificador único de la asignatura.
     * @return View → Retorna la vista tutor.editar-asignatura con los datos de la asignatura.
     */
    public function formularioModificarAsignatura(int $carrera_id, int $asignatura_id): View
    {
        $asignatura = Asignatura::where('id', $asignatura_id)->where('carrera_id', $carrera_id)->firstOrFail();
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar asignaturas.", "tutor.presentacion", $asignatura->tutor_id);
        $tutor_id = $asignatura->tutor_id;
        return view('tutor.editar-asignatura', compact('asignatura', 'carrera_id', 'tutor_id'));
    }


    /**
     * Este método:
     * → Modifica la información de una asignatura con datos validados.
     * → Solo permite la modificación a usuarios con categoría "Bienestar".
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param AsignaturaRequest $regla → Datos validados de la asignatura a modificar.
     * @param Asignatura $asignatura → Objeto asignatura con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function modificarAsignatura(AsignaturaRequest $regla, Asignatura $asignatura): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar asignaturas.", "tutor.presentacion", $asignatura->tutor_id);
        $datos = $regla->validated();
        $asignatura->update($datos);
        $tutor = Tutor::findOrFail($asignatura->tutor_id);
        $this->registrarAccion(auth()->id(), 'Modificar asignatura', "Modificó la asignatura del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', ['id' => $tutor->id])->with('success', 'La asignatura fue modificada exitosamente.');
    }

    /**
     * Este método:
     * → Elimina una asignatura de la base de datos.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param int $tutor_id → Identificador del tutor asociado.
     * @param int $id → Identificador de la asignatura a eliminar.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function eliminarAsignatura(int $tutor_id, int $id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar asignaturas.", "tutor.presentacion", $tutor_id);
        $asignatura = Asignatura::with('tutor')->findOrFail($id);
        $tutor = $asignatura->tutor;
        $asignatura->delete();
        $this->registrarAccion(auth()->id(), 'Eliminar asignatura', "Eliminó la asignatura {$asignatura->Nombre} del tutor {$tutor->Nombre} {$tutor->Apellido}");
        return redirect()->route('tutor.presentacion', $tutor->id)->with('success', 'La asignatura fue eliminada exitosamente');
    }
}
