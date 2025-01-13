<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Http\Requests\SalaRequest;
use App\Traits\RegistraHistorial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SalaController extends Controller
{
    use RegistraHistorial;

    /**
     * Este método:
     * → Obtiene todas las salas con sus infantes asociados.
     * → Prepara los datos para mostrarlos en una vista general.
     * 
     * @return View → Retorna la vista con las salas y sus infantes.
     */
    public function listar(): View
    {
        $salas = Sala::all();
        $sala1 = $salas->get(0);
        $sala2 = $salas->get(1);
        $sala3 = $salas->get(2);

        if ($sala1) {
            $sala1->infante = $sala1->infante()->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_sala1');
        } else {
            $sala1 = null;
        }

        if ($sala2) {
            $sala2->infante = $sala2->infante()->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_sala2');
        } else {
            $sala2 = null;
        }

        if ($sala3) {
            $sala3->infante = $sala3->infante()->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_sala3');
        } else {
            $sala3 = null;
        }
        return view('sala.index', compact('sala1', 'sala2', 'sala3'));
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
        $usuarioAutenticado = auth()->user();
        if ($usuarioAutenticado->Categoria !== "Bienestar") {
            return redirect()->route('sala.index')->with('error', 'No tienes permiso para registrar salas.');
        }

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
        $usuarioAutenticado = auth()->user();
        if ($usuarioAutenticado->Categoria !== "Bienestar") {
            return redirect()->route('sala.index')->with('error', 'No tienes permiso para modificar salas.');
        }
        $datos = $regla->validated();
        $sala->update($datos);
        $this->registrarAccion(auth()->id(), 'Sala modificada', "Se modificó la sala {$sala->Nombre}");
        return redirect()->route('sala.index')->with('success', 'La sala fue modificada exitosamente.');
    }


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
        try{
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
        catch (\Exception $e) {
            return redirect()->route('sala.index')->with('error', 'Hubo un problema al intentar eliminar la sala.');
        }
    }
    
}
