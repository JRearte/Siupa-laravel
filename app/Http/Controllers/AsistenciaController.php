<?php

namespace App\Http\Controllers;

use App\Traits\RegistraHistorial;

use App\Models\Asistencia;
use App\Models\Infante;
use App\Models\Sala;
use App\Http\Requests\AsistenciaRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
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
    



    public function generarReporteEspecifico(int $infante_id, int $sala_id)
    {
        $infante = Infante::with([
            'asistencias' => function ($consulta) {
                $consulta->orderBy('Fecha', 'asc');
            },
            'asistencias.usuario',
            'sala'
        ])
            ->where('id', $infante_id)
            ->where('sala_id', $sala_id)
            ->firstOrFail();

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
            'totalGeneral' => "{$calculoHoras['totalHoras']} horas {$calculoHoras['totalMinutos']} minutos"
        ]);

        //return $pdf->stream();
        return $pdf->download('Reporte de ' . $infante->Nombre . ' ' . $infante->Apellido . ' ' . now()->format('d-m-Y') . '.pdf');
    }

    private function calcularHorasPorMes($asistencias)
    {
        $horasPorMes = [];
        $totalMinutos = 0;

        foreach ($asistencias as $asistencia) {
            $fecha = Carbon::parse($asistencia->Fecha);
            $mes = $fecha->format('Y-m');

            $horaIngreso = Carbon::parse($asistencia->Hora_Ingreso);
            $horaSalida = Carbon::parse($asistencia->Hora_Salida);

            $minutos = max(0, $horaIngreso->diffInMinutes($horaSalida));

            if (!isset($horasPorMes[$mes])) {
                $horasPorMes[$mes] = 0;
            }
            $horasPorMes[$mes] += $minutos;
            $totalMinutos += $minutos;
        }

        foreach ($horasPorMes as $mes => $minutos) {
            $horasPorMes[$mes] = [
                'horas' => intdiv($minutos, 60),
                'minutos' => $minutos % 60
            ];
        }

        return [
            'horasPorMes' => $horasPorMes,
            'totalHoras' => intdiv($totalMinutos, 60),
            'totalMinutos' => $totalMinutos % 60
        ];
    }
}
