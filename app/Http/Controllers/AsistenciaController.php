<?php

namespace App\Http\Controllers;

use App\Traits\RegistraHistorial;

use App\Models\Asistencia;
use App\Models\Infante;
use App\Http\Requests\AsistenciaRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Carbon;

class AsistenciaController extends Controller
{
    use RegistraHistorial;



    public function generarReporteEspecifico(int $infanteId, int $salaId)
    {
        $infante = Infante::with([
            'asistencias' => function ($consulta) {
                $consulta->orderBy('Fecha', 'asc');
            },
            'asistencias.usuario',
            'sala'
        ])
            ->where('id', $infanteId)
            ->where('sala_id', $salaId)
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
