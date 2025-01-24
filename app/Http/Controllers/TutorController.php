<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Http\Requests\TutorRequest;
use App\Traits\RegistraHistorial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TutorController extends Controller
{
    use RegistraHistorial;

    public function listar(): View
    {

        $trabajadores = Tutor::with('infantes')->where('Tipo_tutor', 'Trabajador')->paginate(7, ['*'], 'page_trabajador');
        $alumnos = Tutor::with('infantes')->where('Tipo_tutor', 'Alumno')->paginate(7, ['*'], 'page_alumno');
    
        return view('tutor.index', compact('trabajadores', 'alumnos'));
    }
    
}