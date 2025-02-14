<?php

namespace App\Http\Controllers;

use App\Models\Infante;
use App\Models\Sala;
use App\Models\Tutor;
use App\Models\Medico;
use App\Http\Requests\InfanteRequest;
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
        $infante = Infante::with(['familiares', 'medicos', 'asistencias'])->findOrFail($id);

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
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar infantes.", "tutor.index");
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
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar infantes.", "tutor.index");
        $datos = $regla->validated();
        $tutor = Tutor::findOrFail($datos['tutor_id']);

        if ($tutor->Habilitado == 0) {
            $datos['Habilitado'] = 0;
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
        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar infantes.", "tutor.index");

        $infante = Infante::findOrFail($id);
        $nombre = $infante->Nombre;
        $apellido = $infante->Apellido;
        $tutor_id = $infante->tutor_id;
        $infante->delete();

        $this->registrarAccion(auth()->id(), 'Eliminar infante', "Eliminó al infante {$nombre} {$apellido}");
        return redirect()->route('tutor.presentacion', $tutor_id)->with('success', 'El infante fue eliminado exitosamente.');
    }

    /* ==================== Datos Médicos ========== */

    public function formularioRegistrarMedico(int $infante_id): View
    {
        $medico = new Medico(['infante_id' => $infante_id]);
        return view('infante.agregar-medico', compact('medico', 'infante_id'));
    }

    public function registrarMedico(MedicoRequest $regla, int $infante_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar datos médicos.", "tutor.index");
        $infante = Infante::findOrFail($infante_id);
        $datos = $regla->validated();
        Medico::create($datos);
        $this->registrarAccion(auth()->id(), 'Registrar dato médico', "Registró un dato médico del infante {$infante->Nombre} {$infante->Apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante_id])->with('success', 'El dato médico fue registrado exitosamente.');
    }

    public function eliminarMedico(int $id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar datos médicos.", "tutor.index");
        $medico = Medico::findOrFail($id);
        $infante = Infante::findOrFail($medico->infante_id);
        $nombre = $infante->Nombre;
        $apellido = $infante->Apellido;
        $medico->delete();

        $this->registrarAccion(auth()->id(), 'Eliminar dato médico', "Eliminó un dato médico del infante {$nombre} {$apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('success', 'El dato médico fue eliminado exitosamente.');
    }
}
