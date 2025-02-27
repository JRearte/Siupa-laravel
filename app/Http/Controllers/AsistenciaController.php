<?php

namespace App\Http\Controllers;

use App\Traits\RegistraHistorial;

use App\Models\Asistencia;
use App\Models\Infante;
use App\Models\Sala;
use App\Http\Requests\AsistenciaRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class AsistenciaController extends Controller
{
    use RegistraHistorial;

    public function listar(Request $regla): View
    {
        $buscar = $regla->input('buscar');
        $salas = Sala::all();
        $datos = [];

        foreach ($salas as $index => $sala) {
            if (!$sala) {
                continue;
            }

            // ==================== Filtro de búsqueda ====================
            if ($buscar) {
                $sala->infante = $sala->infante()
                    ->where('Habilitado', 1)
                    ->where(function ($query) use ($buscar) {
                        $query->where('Nombre', 'LIKE', "%$buscar%")
                            ->orWhere('Apellido', 'LIKE', "%$buscar%")
                            ->orWhere('Categoria', 'LIKE', "%$buscar%");
                    })->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_sala' . ($index + 1));
            } else {
                $sala->infante = $sala->infante()->where('Habilitado', 1)->orderBy('apellido', 'asc')->paginate(7, ['*'], 'page_sala' . ($index + 1));
            }

            $sala->infante->appends(['buscar' => $buscar]);
            $datos['sala' . ($index + 1)] = $sala;
        }

        $sala1 = $datos['sala1'] ?? null;
        $sala2 = $datos['sala2'] ?? null;
        $sala3 = $datos['sala3'] ?? null;

        return view('asistencia.index', compact('sala1', 'sala2', 'sala3', 'buscar'));
    }

    public function presentar(int $infante_id, Request $regla): View
    {
        $mes = $regla->input('mes', now()->format('Y-m'));

        $infante = Infante::with([
            'asistencias' => function ($consulta) use ($mes) {
                $consulta->whereYear('Fecha', substr($mes, 0, 4))
                    ->whereMonth('Fecha', substr($mes, 5, 2))
                    ->orderBy('Fecha');
            },
            'asistencias.usuario'
        ])->findOrFail($infante_id);

        $asistenciasPorDia = $infante->asistencias->groupBy(fn($a) => $a->Fecha->format('Y-m-d'));
        return view('asistencia.presentacion', compact('infante', 'mes', 'asistenciasPorDia'));
    }


    /**
     * Este método:
     * → Muestra el formulario para registrar una nueva asistencia.
     * → Genera un objeto asistencia con los datos iniciales del infante.
     * 
     * @param int $infante_id → Identificador único del infante.
     * @param string $fecha → Fecha de la asistencia en formato de cadena.
     * @return View → Retorna la vista asistencia.agregar con el objeto asistencia.
     */
    public function formularioRegistrar(int $infante_id, string $fecha): View
    {
        $this->validarPermiso(["Coordinador", "Maestro"], "No tienes permiso para registrar asistencias.", "asistencia.index");

        $usuarioAutentificado = auth()->id();
        $infante = Infante::findOrFail($infante_id);

        $fecha = Carbon::parse($fecha);
        $asistencia = new Asistencia([
            'Fecha' => $fecha,
            'infante_id' => $infante->id,
            'sala_id' => $infante->sala_id,
            'usuario_id' => $usuarioAutentificado
        ]);

        return view('asistencia.agregar', compact('asistencia'));
    }

    /**
     * Este método:
     * → Registra una nueva asistencia en la base de datos con datos validados.
     * → Solo permite el registro a usuarios con categoría "Coordinador" o "Maestro".
     * → Registra la acción en el historial.
     * 
     * @param AsistenciaRequest $regla → Datos validados de la asistencia a registrar.
     * @return RedirectResponse → Redirige a la página de presentación con un mensaje de éxito o error.
     */
    public function registrar(AsistenciaRequest $regla): RedirectResponse
    {
        $this->validarPermiso(["Coordinador", "Maestro"], "No tienes permiso para registrar asistencias.", "asistencia.index");
        $datos = $regla->validated();
        $asistencia = Asistencia::create($datos);
        $infante = Infante::findOrFail($asistencia->infante_id);
        $this->registrarAccion(auth()->id(), 'Registrar asistencia', "Registró la asistencia de {$infante->Nombre} {$infante->Apellido} ");
        return redirect()->route('asistencia.presentacion', $infante->id)->with('success', 'La asistencia fue registrada exitosamente.');
    }

    /**
     * Este método:
     * → Recupera los datos de una asistencia por su identificador único.
     * → Redirige al formulario de edición con la información de la asistencia cargada.
     * 
     * @param int $id → Identificador único de la asistencia.
     * @return View → Retorna la vista asistencia.editar con los datos de la asistencia.
     */
    public function formularioModificar(int $id): View
    {
        $asistencia = Asistencia::findOrFail($id);
        $this->validarPermisoConID(["Coordinador"], "No tienes permiso para modificar asistencias.", "asistencia.presentacion", $asistencia->infante_id);
        return view('asistencia.editar', compact('asistencia'));
    }

    /**
     * Este método:
     * → Modifica la información de una asistencia en la base de datos con datos validados.
     * → Solo permite la modificación a usuarios con categoría "Coordinador".
     * → Registra la acción en el historial.
     * 
     * @param AsistenciaRequest $regla → Datos validados de la asistencia a modificar.
     * @param Asistencia $asistencia → Objeto asistencia con la estructura y datos actuales.
     * @return RedirectResponse → Redirige a la página de presentación con un mensaje de éxito o error.
     */
    public function modificar(AsistenciaRequest $regla, Asistencia $asistencia): RedirectResponse
    {
        $infante = $asistencia->infante;
        $this->validarPermisoConID(["Coordinador"], "No tienes permiso para modificar asistencias.", "asistencia.presentacion", $infante->id);
        $datos = $regla->validated();
        $asistencia->update($datos);
        $this->registrarAccion(auth()->id(), 'Modificar asistencia', "Modificó la asistencia de {$infante->Nombre} {$infante->Apellido} ");
        return redirect()->route('asistencia.presentacion', $infante->id)->with('success', 'La asistencia fue modificada exitosamente.');
    }

    /**
     * Este método:
     * → Elimina una asistencia de la base de datos por su identificador único.
     * → Solo permite la eliminación a usuarios con categoría "Coordinador".
     * → Registra la acción de eliminación en el historial.
     * 
     * @param int $id → Identificador único de la asistencia a eliminar.
     * @return RedirectResponse → Redirige a la página de presentación con un mensaje de éxito o error.
     */
    public function eliminar(int $id): RedirectResponse
    {
        $asistencia = Asistencia::with('infante')->findOrFail($id);
        $infante = $asistencia->infante;
        $fecha = $asistencia->Fecha->format('d/m');
        $this->validarPermisoConID(["Coordinador"], "No tienes permiso para eliminar asistencias.", "asistencia.presentacion", $infante->id);
        $asistencia->delete();
        $this->registrarAccion(auth()->id(), 'Eliminar asistencia', "Eliminó la asistencia del {$fecha} del infante {$infante->Nombre} {$infante->Apellido} ");
        return redirect()->route('asistencia.presentacion', $infante->id)->with('success', 'La asistencia fue eliminada exitosamente.');
    }


    public function generarReporteEspecifico(int $infante_id, int $sala_id)
    {
        $infante = Infante::with([
            'asistencias.usuario',
            'sala'
        ])
            ->where('id', $infante_id)
            ->where('sala_id', $sala_id)
            ->firstOrFail();
        
        $observaciones = $infante->asistencias->whereNotNull('Observacion');

        if (!$infante->asistencias->count()) {
            return abort(404, 'El infante no tiene asistencias registradas.');
        }

        // Obtener la primera asistencia del año
        $primerAsistencia = Asistencia::where('infante_id', $infante_id)
            ->whereYear('Fecha', now()->year)
            ->orderBy('Fecha', 'asc')
            ->first();

        // Obtener la última asistencia del año
        $ultimaAsistencia = Asistencia::where('infante_id', $infante_id)
            ->whereYear('Fecha', now()->year)
            ->orderBy('Fecha', 'desc')
            ->first();

        // Calcular la duración de cada asistencia
        foreach ($infante->asistencias as $asistencia) {
            $horaIngreso = Carbon::parse($asistencia->Hora_Ingreso);
            $horaSalida = Carbon::parse($asistencia->Hora_Salida);

            $totalMinutos = max(0, $horaIngreso->diffInMinutes($horaSalida));
            $horas = intdiv($totalMinutos, 60);
            $minutos = $totalMinutos % 60;

            $asistencia->duracion = "{$horas} hora {$minutos} minutos";
        }

        $calculoHoras = $this->calcularHorasPorMes($infante->asistencias);

        $pdf = PDF::loadView('reporte/reporte-asistencia-infante', [
            'infante' => $infante,
            'horasPorMes' => $calculoHoras['horasPorMes'],
            'totalGeneral' => "{$calculoHoras['totalHoras']} horas {$calculoHoras['totalMinutos']} minutos",
            'totalAsistencias' => $calculoHoras['totalAsistencias'],
            'primerAsistencia' => $primerAsistencia ? Carbon::parse($primerAsistencia->Fecha)->format('d/m/Y') : 'No disponible',
            'ultimaAsistencia' => $ultimaAsistencia ? Carbon::parse($ultimaAsistencia->Fecha)->format('d/m/Y') : 'No disponible',
            'observaciones' => $observaciones
        ]);

        return $pdf->download('Reporte de ' . $infante->Nombre . ' ' . $infante->Apellido . ' ' . now()->format('d-m-Y') . '.pdf');
    }


    private function calcularHorasPorMes($asistencias)
    {
        $horasPorMes = [];
        $totalMinutos = 0;
        $asistenciasPorMes = [];
        $totalAsistencias = 0;
        $estadosPorMes = [];

        foreach ($asistencias as $asistencia) {
            $fecha = Carbon::parse($asistencia->Fecha);
            $mes = $fecha->format('Y-m');
            $estado = $asistencia->Estado;

            $horaIngreso = Carbon::parse($asistencia->Hora_Ingreso);
            $horaSalida = Carbon::parse($asistencia->Hora_Salida);

            $minutos = max(0, $horaIngreso->diffInMinutes($horaSalida));

            if (!isset($horasPorMes[$mes])) {
                $horasPorMes[$mes] = 0;
                $asistenciasPorMes[$mes] = 0;
                $estadosPorMes[$mes] = [
                    'Presente' => 0,
                    'Ausente Justificado' => 0,
                    'Ausente Injustificado' => 0
                ];
            }

            $horasPorMes[$mes] += $minutos;
            $asistenciasPorMes[$mes]++;
            $totalMinutos += $minutos;
            $totalAsistencias++;

            if (isset($estadosPorMes[$mes][$estado])) {
                $estadosPorMes[$mes][$estado]++;
            }
        }

        foreach ($horasPorMes as $mes => $minutos) {
            $horasPorMes[$mes] = [
                'horas' => intdiv($minutos, 60),
                'minutos' => $minutos % 60,
                'asistencias' => $asistenciasPorMes[$mes],
                'estados' => $estadosPorMes[$mes]
            ];
        }

        return [
            'horasPorMes' => $horasPorMes,
            'totalHoras' => intdiv($totalMinutos, 60),
            'totalMinutos' => $totalMinutos % 60,
            'totalAsistencias' => $totalAsistencias
        ];
    }
}
