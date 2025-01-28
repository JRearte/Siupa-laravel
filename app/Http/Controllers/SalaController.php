<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Http\Requests\SalaRequest;
use App\Traits\RegistraHistorial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SalaController extends Controller
{
    use RegistraHistorial;

    /**
     * Este método:
     * → Obtiene todas las salas con sus infantes asociados.
     * → Brinda un filtro por: nombre, apellido y categoría.
     * → Proporciona datos estadisticos de las salas segun su capacidad.
     * → Prepara los datos para mostrarlos en una vista general.
     * 
     * @return View → Retorna la vista con las salas y sus infantes.
     */
    public function listar(Request $regla): View
    {
        $buscar = $regla->input('buscar');
        $salas = Sala::all();
        $datos = [];

        foreach ($salas as $index => $sala) {
            if (!$sala) {
                continue;
            }

            // ==================== Estadísticas generales ====================
            $sala->cantidad = $sala->infante()->count();
            $sala->habilitados = $sala->infante()->where('Habilitado', 1)->count();
            $sala->deshabilitados = $sala->cantidad - $sala->habilitados;
            $sala->ingresantes = $sala->infante()->where('Categoria', 'Ingresante')->count();
            $sala->readmitidos = $sala->cantidad - $sala->ingresantes;

            $sala->porcentajeCapacidad = ($sala->Capacidad > 0) ? ($sala->habilitados / $sala->Capacidad) * 100 : 0;
            $sala->porcentajeHabilitados = ($sala->cantidad > 0) ? ($sala->habilitados / $sala->cantidad) * 100 : 0;
            $sala->porcentajeDeshabilitados = ($sala->cantidad > 0) ? ($sala->deshabilitados / $sala->cantidad) * 100 : 0;
            $sala->porcentajeIngresantes = ($sala->cantidad > 0) ? ($sala->ingresantes / $sala->cantidad) * 100 : 0;
            $sala->porcentajeReadmitidos = ($sala->cantidad > 0) ? ($sala->readmitidos / $sala->cantidad) * 100 : 0;

            // ==================== Filtro de búsqueda ====================
            if ($buscar) {
                $sala->infante = $sala->infante()
                    ->where(function ($query) use ($buscar) {
                        $query->where('Nombre', 'LIKE', "%$buscar%")
                            ->orWhere('Apellido', 'LIKE', "%$buscar%")
                            ->orWhere('Categoria', 'LIKE', "%$buscar%");
                    })->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_sala' . ($index + 1));
            } else {
                $sala->infante = $sala->infante()->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_sala' . ($index + 1));
            }

            $sala->infante->appends(['buscar' => $buscar]);
            $datos['sala' . ($index + 1)] = $sala;
        }

        $sala1 = $datos['sala1'] ?? null;
        $sala2 = $datos['sala2'] ?? null;
        $sala3 = $datos['sala3'] ?? null;

        return view('sala.index', compact('sala1', 'sala2', 'sala3', 'buscar'));
    }


    /**
     * Este método:
     * → Muestra el formulario para registrar una nueva sala.
     * → Prepara un objeto sala vacía para su carga inicial.
     * 
     * @return View → Retorna la vista sala.agregar con el objeto sala.
     */
    public function formularioRegistrar(): View
    {
        $sala = new Sala();
        return view('sala.agregar', compact('sala'));
    }


    /**
     * Este método:
     * → Registra una nueva sala en la base de datos con los datos validados.
     * → Solo permite el registro a usuarios con categoría "Bienestar".
     * → Solo permite registrar un máximo de 3 salas.
     * → Registra la acción en el historial.
     * 
     * @param SalaRequest $regla → Datos validados de la sala a registrar.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
     */
    public function registrar(SalaRequest $regla): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar salas.", "sala.index");

        if (Sala::count() >= 3) {
            return redirect()->route('sala.index')->with('error', 'Solo se puedes tener un máximo de 3 salas.');
        }

        $datos = $regla->validated();
        $sala = Sala::create($datos);

        $this->registrarAccion(auth()->id(), 'Sala registrada', "Se registró la sala {$sala->Nombre}");
        return redirect()->route('sala.index')->with('success', 'La sala fue creada exitosamente.');
    }


    /**
     * Este método:
     * → Recupera los datos de una sala por su identificador único.
     * → Redirige al formulario de edición con la información de la sala cargada.
     * 
     * @param int $id → Identificador único de la sala.
     * @return View → Retorna la vista sala.editar con los datos de la sala.
     */
    public function formularioModificar(int $id): View
    {
        $sala = Sala::find($id);
        return view('sala.editar', compact('sala'));
    }

    /**
     * Este método:
     * → Modifica la información de una sala en la base de datos con datos validados.
     * → Solo permite la modificación de salas a usuarios con categoría "Bienestar".
     * → Registra la acción de modificación en el historial.
     * 
     * @param SalaRequest $regla → Datos validados de la sala a modificar.
     * @param Sala $sala → Objeto de tipo sala que contiene la estructura y los datos actuales.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
     */
    public function modificar(SalaRequest $regla, Sala $sala): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para modificar salas.", "sala.index");
        $datos = $regla->validated();
        $sala->update($datos);
        $this->registrarAccion(auth()->id(), 'Sala modificada', "Se modificó la sala {$sala->Nombre}");
        return redirect()->route('sala.index')->with('success', 'La sala fue modificada exitosamente.');
    }


    /**
     * Este método:
     * → Muestra un mensaje de advertencia para confirmar la eliminación de la sala.
     * → Redirige al usuario a la página de confirmación de eliminación.
     * 
     * @param int $id → Identificador único del usuario a eliminar.
     * @return View → Retorna la vista sala.advertencia con los datos de la sala.
     */
    public function advertirEliminacion(int $id): View
    {
        $sala = Sala::findOrFail($id);
        return view('sala.advertencia', compact('sala'));
    }

    /**
     * Este método:
     * → Elimina una sala de la base de datos por su identificador único.
     * → Verifica si la sala está vacía antes de proceder con la eliminación.
     * → Registra la acción de eliminación en el historial.
     * 
     * @param int $id → Identificador único de la sala a eliminar.
     * @return RedirectResponse → Redirige a la página principal con un mensaje de éxito o error.
     */
    public function eliminar(int $id): RedirectResponse
    {

        $this->validarPermiso("Bienestar", "No tienes permiso para eliminar salas.", "sala.index");
        $sala = Sala::find($id);
        if (!$sala) {
            return redirect()->route('sala.index')->with('error', 'La sala no existe.');
        }
        if ($sala->infante()->count() > 0) {
            return redirect()->route('sala.index')->with('error', 'La sala aún tiene infantes asignados y no se puede eliminar.');
        }
        $nombre = $sala->Nombre;
        $sala->delete();
        $this->registrarAccion(auth()->id(), 'Sala eliminada', "Se eliminó la sala {$nombre}");
        return redirect()->route('sala.index')->with('success', 'La sala fue eliminada exitosamente.');
    }
}
