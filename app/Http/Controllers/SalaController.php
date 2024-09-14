<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Http\Requests\SalaRequest;

class SalaController extends Controller
{
    /**
     * Esta función permite obtener un listado de las salas de la base de datos.
     */
    public function listar()
    {
        $salas = Sala::orderBy('edad', 'asc')->withCount('infantes')->paginate(10);
        return view('sala.listar', compact('salas'))->with('i',(request()->input('page',1) - 1) * $salas->perPage());
    }

    /**
     * Esta función permite mostrar un formulario complementario con el registrar sala,
     * para poder cargar la información de un objeto sala.
     * Redirige al usuario al formulario de registro.
     */
    public function agregar()
    {
        $sala = new Sala();
        return view('sala.agregar', compact('sala'));
    }

    /**
     * Esta función permite registrar una nueva sala en la base de datos, con los datos validados.
     * El usuario sera redirigido a la páagina principal del gestor de sala.
     * @param SalaRequest $solicitud → credencial que validada de la sala.
     */
    public function registrar(SalaRequest $solicitud)
    {
        $datos = $solicitud->validated();
        Sala::create($datos);
        return redirect()->route('sala.listar')->with('success', 'La sala fue creada exitosamente.');
    }

    /**
     * Esta función permite obtener los datos de una sala a través de su id.
     * Es complementaria de la función para modificar y redirige al formulario con la información.
     * @param int $id → identificador de la sala.
     */
    public function editar(int $id)
    {
        $sala = Sala::find($id);
        return view('sala.editar', compact('sala'));
    }

    /**
     * Esta función permite modificar la información de una sala en la base de datos, validando sus datos.
     * El usuario sera redirigido a la página principal del gestor de sala.
     * @param SalaRequest $solicitud → credencial validada de la sala.
     * @param Sala $sala → objeto de tiipo sala que contiene su estructura.
     */
    public function modificar(SalaRequest $solicitud, Sala $sala)
    {
        $datos = $solicitud->validated();
        $sala->update($datos);
        return redirect()->route('sala.listar')->with('success', 'La sala fue modificada exitosamente.');
    }

    /**
     * Esta función permite eliminar una sala de la base de datos a través de su id.
     * El usuario sera redirigido a la página principal del gestor de sala.
     * @param int $id → identificador de la sala.
     */
    public function eliminar(int $id)
    {
        Sala::find($id)->delete();
        return redirect()->route('sala.listar')->with('success', 'La sala fue eliminada exitosamente.');
    }
}
