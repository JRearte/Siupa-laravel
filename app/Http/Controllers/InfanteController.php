<?php

namespace App\Http\Controllers;

use App\Models\Infante;
use App\Models\Sala;
use App\Http\Requests\InfanteRequest;

use App\Traits\RegistraHistorial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class InfanteController extends Controller
{
    use RegistraHistorial;

    public function presentar(int $id): View
    {
        $infante = Infante::with(['familiares', 'medicos', 'asistencias'])->findOrFail($id);
        $edad = Carbon::parse($infante->Fecha_de_nacimiento)->age;

        return view('infante.presentacion', ['infante' => $infante, 'edad' => $edad]);
    }

    public function formularioRegistrar(int $tutor_id): View
    {
        $infante = new Infante(['tutor_id' => $tutor_id]);
        $sala = Sala::findOrFail(1);
        return view('infante.agregar', compact('infante', 'tutor_id', 'sala'));
    }


    public function registrar(InfanteRequest $regla, int $tutor_id): RedirectResponse
    {
        $this->validarPermiso("Bienestar", "No tienes permiso para registrar infantes.", "tutor.index");
    
        $datos = $regla->validated();
        $datos['tutor_id'] = $tutor_id;
    
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
    

    public function formularioModificar(int $id): View
    {
        $infante = Infante::findOrFail($id);
        $salas = Sala::all();
        return view('infante.editar', compact('infante', 'salas'));
    }

    public function modificar(InfanteRequest $regla, Infante $infante): RedirectResponse
    {
        $datos = $regla->validated();
        $infante->update($datos);
        $this->registrarAccion(auth()->id(), 'Modificar infante', "Modificó al infante {$infante->Nombre} {$infante->Apellido}");
        return redirect()->route('infante.presentacion', ['id' => $infante->id])->with('success', 'El infante fue modificado exitosamente.');
    }
    
}