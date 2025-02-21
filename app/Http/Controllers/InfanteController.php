<?php

namespace App\Http\Controllers;

use App\Models\Infante;
use App\Models\Sala;
use App\Models\Tutor;
use App\Models\Medico;
use App\Models\Familia;
use App\Http\Requests\InfanteRequest;
use App\Http\Requests\FamiliaRequest;
use App\Http\Requests\MedicoRequest;
use App\Traits\RegistraHistorial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class InfanteController extends Controller
{
    use RegistraHistorial;

    /**
     * Este método:
     * → Recupera los datos de un infante junto con sus familiares, médicos y asistencias.
     * → Calcula y formatea la edad del infante en años y meses.
     * → Redirige a la vista de presentación del infante con la información obtenida.
     *
     * @param int $id → Identificador único del infante.
     * @return View → Retorna la vista infante.presentacion con los datos del infante y su edad formateada.
     */
    public function presentar(int $id): View
    {
        $infante = Infante::with([
            'familiares',
            'medicos' => function ($consulta) {
                $consulta->orderBy('Tipo', 'asc');
            },
            'asistencias',
            'tutor'
        ])->findOrFail($id);

        foreach ($infante->familiares as $familiar) {
            $familiar->edad = Carbon::parse($familiar->Fecha_de_nacimiento)->age;
        }

        $fechaNacimiento = Carbon::parse($infante->Fecha_de_nacimiento);
        $edad = $fechaNacimiento->diff(Carbon::now());

        if ($edad->y >= 2) {
            $edadF = "{$edad->y} años y {$edad->m} meses";
        } elseif ($edad->y == 1) {
            $edadF = "1 año y {$edad->m} meses";
        } else {
            $edadF = "{$edad->m} meses";
        }

        return view('infante.presentacion', ['infante' => $infante, 'edad' => $edadF]);
    }

    /**
     * Este método:
     * → Muestra el formulario para registrar un nuevo infante.
     * → Crea una instancia vacía de Infante con el tutor asociado.
     * → Obtiene la sala por defecto con ID 1.
     *
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return View → Retorna la vista infante.agregar con la instancia del infante y la sala cargada.
     */
    public function formularioRegistrar(int $tutor_id): View
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar infantes.", "tutor.presentacion", $tutor_id);
        $infante = new Infante(['tutor_id' => $tutor_id]);
        $sala = Sala::findOrFail(1);
        return view('infante.agregar', compact('infante', 'tutor_id', 'sala'));
    }

    /**
     * Este método:
     * → Registra un infante con validaciones previas.
     * → Verifica que el tutor esté habilitado para definir el estado del infante.
     * → Asigna la sala correspondiente según la edad del infante.
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param InfanteRequest $regla → Datos validados del infante a registrar.
     * @param int $tutor_id → Identificador del tutor asociado.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito o error si no hay una sala disponible.
     */
    public function registrar(InfanteRequest $regla, int $tutor_id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar infantes.", "tutor.presentacion", $tutor_id);
        $tutor = Tutor::findOrFail($tutor_id);

        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;

        if ($tutor->Habilitado == 0) {
            $datos['Habilitado'] = 0;
        }

        $edad = Carbon::parse($datos['Fecha_de_nacimiento'])->age;
        $sala = Sala::where('Edad', $edad)->first();

        if (!$sala) {
            return redirect()->route('tutor.presentacion', ['id' => $tutor_id])->with('error', 'No hay una sala disponible para esta edad.');
        }

        $datos['sala_id'] = $sala->id;
        $infante = Infante::create($datos);

        $this->registrarAccion(auth()->id(), 'Registrar infante', "Registró al infante {$infante->Nombre} {$infante->Apellido}");
        return redirect()->route('tutor.presentacion', ['id' => $tutor_id])->with('success', 'El infante fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de un infante para su modificación.
     * → Obtiene todas las salas disponibles para su asignación.
     *
     * @param int $id → Identificador del infante.
     * @return View → Retorna la vista infante.editar con los datos del infante y las salas disponibles.
     */
    public function formularioModificar(int $id): View
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar infantes.", "infante.presentacion", $id);
        $infante = Infante::findOrFail($id);
        $salas = Sala::all();
        return view('infante.editar', compact('infante', 'salas'));
    }

    /**
     * Este método:
     * → Modifica los datos de un infante con validaciones previas.
     * → Verifica que el tutor esté habilitado antes de modificar el estado del infante.
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param InfanteRequest $regla → Datos validados del infante a modificar.
     * @param Infante $infante → Instancia del infante con su información actual.
     * @return RedirectResponse → Redirige a la presentación del infante con un mensaje de éxito.
     */
    public function modificar(InfanteRequest $regla, Infante $infante): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar infantes.", "infante.presentacion", $infante->id);
        $datos = $regla->validated();
        $tutor = Tutor::findOrFail($datos['tutor_id']);

        if ($tutor->Habilitado == 0) {
            $datos['Habilitado'] = 0;
            return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('info', "El tutor del infante está deshabilitado");
        }

        $infante->update($datos);
        $this->registrarAccion(auth()->id(), 'Modificar infante', "Modificó al infante {$infante->Nombre} {$infante->Apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('success', 'El infante fue modificado exitosamente.');
    }

    /**
     * Este método:
     * → Recupera la información de un infante antes de proceder con su eliminación.
     * → Redirige a una vista de advertencia para confirmar la eliminación.
     *
     * @param int $id → Identificador del infante.
     * @return View → Retorna la vista infante.advertencia con la información del infante.
     */
    public function advertirEliminacion(int $id): View
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar infantes.", "infante.presentacion", $id);
        $infante = Infante::findOrFail($id);
        return view('infante.advertencia', compact('infante'));
    }

    /**
     * Este método:
     * → Elimina un infante de la base de datos.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param int $id → Identificador del infante a eliminar.
     * @return RedirectResponse → Redirige a la presentación del tutor con un mensaje de éxito.
     */
    public function eliminar(int $id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar infantes.", "infante.presentacion", $id);

        $infante = Infante::findOrFail($id);
        $nombre = $infante->Nombre;
        $apellido = $infante->Apellido;
        $tutor_id = $infante->tutor_id;
        $infante->delete();

        $this->registrarAccion(auth()->id(), 'Eliminar infante', "Eliminó al infante {$nombre} {$apellido}");
        return redirect()->route('tutor.presentacion', $tutor_id)->with('success', 'El infante fue eliminado exitosamente.');
    }

    /* ==================== Datos Médicos ========== */

    /**
     * Este método:
     * → Muestra el formulario para registrar un dato médico.
     * → Crea una instancia vacía de Medico asociada a un infante.
     *
     * @param int $infante_id → Identificador del infante.
     * @return View → Retorna la vista infante.formulario-medico con la instancia del dato médico.
     */
    public function formularioRegistrarMedico(int $infante_id): View
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar datos médicos.", "infante.presentacion", $infante_id);
        $medico = new Medico(['infante_id' => $infante_id]);
        return view('infante.formulario-medico', compact('medico', 'infante_id'));
    }

    /**
     * Este método:
     * → Registra un dato médico con validaciones previas.
     * → Asocia el dato médico a un infante.
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param MedicoRequest $regla → Datos validados del dato médico a registrar.
     * @param int $infante_id → Identificador del infante asociado.
     * @return RedirectResponse → Redirige a la presentación del infante con un mensaje de éxito.
     */
    public function registrarMedico(MedicoRequest $regla, int $infante_id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar datos médicos.", "infante.presentacion", $infante_id);
        $infante = Infante::findOrFail($infante_id);

        $datos = $regla->validated();
        $datos['infante_id'] = $infante_id;
        Medico::create($datos);

        $this->registrarAccion(auth()->id(), 'Registrar dato médico', "Registró un dato médico del infante {$infante->Nombre} {$infante->Apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante_id])->with('success', 'El dato médico fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Elimina un dato médico de la base de datos.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción realizada en el historial del sistema.
     *
     * @param int $id → Identificador del dato médico a eliminar.
     * @return RedirectResponse → Redirige a la presentación del infante con un mensaje de éxito.
     */
    public function eliminarMedico(int $id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar datos médicos.", "infante.presentacion", $id);

        $medico = Medico::findOrFail($id);
        $infante = Infante::findOrFail($medico->infante_id);
        $nombre = $infante->Nombre;
        $apellido = $infante->Apellido;
        $medico->delete();

        $this->registrarAccion(auth()->id(), 'Eliminar dato médico', "Eliminó un dato médico del infante {$nombre} {$apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('success', 'El dato médico fue eliminado exitosamente.');
    }

    /* ==================== Familiar ==================== */

    /**
     * Este método:
     * → Muestra el formulario para registrar un nuevo familiar.
     * → Crea una instancia vacía de Familia con el infante asociado.
     *
     * @param int $infante_id → Identificador del infante asociado.
     * @return View → Retorna la vista infante.agregar-familiar con la instancia del familiar.
     */
    public function formularioRegistrarFamiliar(int $infante_id): View
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar familiares.", "infante.presentacion", $infante_id);
        $familia = new Familia(['infante_id' => $infante_id]);
        return view('infante.agregar-familiar', compact('familia', 'infante_id'));
    }

    /**
     * Este método:
     * → Registra un familiar con validaciones previas.
     * → Asigna el familiar al infante correspondiente.
     * → Registra la acción en el historial del sistema.
     *
     * @param FamiliaRequest $regla → Datos validados del familiar a registrar.
     * @param int $infante_id → Identificador del infante asociado.
     * @return RedirectResponse → Redirige a la presentación del infante con un mensaje de éxito.
     */
    public function registrarFamiliar(FamiliaRequest $regla, int $infante_id): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para registrar familiares.", "infante.presentacion", $infante_id);
        $infante = Infante::findOrFail($infante_id);
        $datos = $regla->validated();
        $datos['infante_id'] = $infante->id;
        Familia::create($datos);

        $this->registrarAccion(auth()->id(), 'Registrar familiar', "Registró un familiar del infante {$infante->Nombre} {$infante->Apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('success', 'El familiar fue registrado exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de un familiar para su modificación.
     *
     * @param int $id → Identificador del familiar.
     * @return View → Retorna la vista infante.editar-familiar con los datos del familiar.
     */
    public function formularioModificarFamiliar(int $id): View
    {
        $familia = Familia::findOrFail($id);
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar familiares.", "infante.presentacion", $familia->infante_id);
        return view('infante.editar-familiar', compact('familia'));
    }

    /**
     * Este método:
     * → Modifica los datos de un familiar con validaciones previas.
     * → Registra la acción en el historial del sistema.
     *
     * @param FamiliaRequest $regla → Datos validados del familiar a modificar.
     * @param Familia $familia → Instancia del familiar con su información actual.
     * @return RedirectResponse → Redirige a la presentación del infante con un mensaje de éxito.
     */
    public function modificarFamiliar(FamiliaRequest $regla, Familia $familia): RedirectResponse
    {
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para modificar familiares.", "infante.presentacion", $familia->infante_id);
        $datos = $regla->validated();
        $infante = Infante::findOrFail($datos['infante_id']);
        $familia->update($datos);

        $this->registrarAccion(auth()->id(), 'Modificar familiar', "Modificó un familiar del infante {$infante->Nombre} {$infante->Apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('success', 'El familiar fue modificado exitosamente.');
    }

    /**
     * Este método:
     * → Elimina un familiar de la base de datos.
     * → Solo permite la eliminación a usuarios con categoría "Bienestar".
     * → Registra la acción en el historial del sistema.
     *
     * @param int $id → Identificador del familiar a eliminar.
     * @return RedirectResponse → Redirige a la presentación del infante con un mensaje de éxito.
     */
    public function eliminarFamiliar(int $id): RedirectResponse
    {
        $familiar = Familia::with('infante')->findOrFail($id);
        $this->validarPermisoConID(["Bienestar"], "No tienes permiso para eliminar familiares.", "infante.presentacion", $familiar->infante_id);
        
        $infante = $familiar->infante;
        $nombre = $familiar->Nombre;
        $apellido = $familiar->Apellido;
        $familiar->delete();
    
        $this->registrarAccion(auth()->id(), 'Eliminar familiar', "Eliminó al familiar {$nombre} {$apellido} del infante {$infante->Nombre} {$infante->Apellido}");
    
        return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('success', 'El familiar fue eliminado exitosamente.');
    }
    
}
