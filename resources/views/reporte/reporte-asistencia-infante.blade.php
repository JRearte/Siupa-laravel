<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Asistencias del Infante</title>
    <style>
        @page {
            margin: 2.5cm 1.5cm 1.5cm 1.5cm;
        }

        header {
            position: fixed;
            top: -2.5cm;
            left: -1.5cm;
            width: 120%;
            height: 2.5cm;
            text-align: center;
            background: #CDD6CF;
        }

        header .titulo {
            position: relative;
            margin: 0;
            top: 18px;
            font-size: 20px;
            font-weight: bold;
        }

        header .subtitulo {
            font-size: 16px;
            margin-top: 35px;
            font-weight: bold;
        }

        header .imagen {
            width: 8%;
            height: auto;
            position: absolute;
            left: 1.5cm;
            top: 50%;
            transform: translateY(-50%);
        }

        footer {
            position: fixed;
            bottom: -1.5cm;
            left: -1.5cm;
            width: 120%;
            height: 1.5cm;
            font-size: 14px;
            background: #CDD6CF;
        }

        footer .fecha {
            position: relative;
            text-align: right;
            left: 650px;
            top: 20px;
        }

        /* ========== TABLA DE ASISTENCIAS ========== */
        .arreglo {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 5px;
            position: relative;
            top: 0.5cm;
            margin-bottom: 30px;
        }

        .arreglo th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .arreglo td {
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .arreglo tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .arreglo tbody tr:hover {
            background-color: #f1f1f1;
        }


        .formato {
            text-align: justify;
            text-justify: inter-word;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 15px;
        }

        .numero {
            width: 25px;
        }

        .fecha {
            width: 100px;
        }

        .observacion {
            width: 100%;
            text-align: left !important;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('imagen/logo.png') }}" alt="logo" class="imagen">
        <h2 class="titulo">Reporte de Asistencias</h2>
        <p class="subtitulo">Sistema de información UPA</p>
    </header>

    <footer>
        <script type="text/php">
            if (isset($pdf)) {
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 10;
                $pageText = "Página $PAGE_NUM";
                $y = 815;
                $x = 260;
                $pdf->text($x, $y, $pageText, $font, $size);
            }
        </script>
        <div>
            <span class="fecha">Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
        </div>
    </footer>


    <p class="formato">
        @php
            $conector = $infante?->Genero == 'Masculino' ? 'EL ' : 'La ';
        @endphp

        {{$conector}} infante <strong>{{ $infante->Nombre }} {{ $infante->Apellido }}</strong> comenzó su cursada en el jardín
        maternal Upa en la sala <strong>{{ $infante->sala->Nombre }}</strong>, desde el
        <strong>{{ $primerAsistencia }}</strong> hasta el <strong>{{ $ultimaAsistencia }}</strong>,
        registrando un total de <strong>{{ $totalAsistencias }}</strong> asistencias a lo largo del año.
        A continuación, se detalla la distribución mensual de sus asistencias, reflejando su continuidad en el año.
    </p>

    <table class="arreglo">
        <thead>
            <tr>
                <th colspan="6">Resumen de Asistencias por Mes</th>
            </tr>
            <tr>
                <th>Mes</th>
                <th>Total de Asistencias</th>
                <th>Horas y Minutos</th>
                <th>Presente</th>
                <th>Ausente Justificado</th>
                <th>Ausente Injustificado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($horasPorMes as $mes => $datos)
                <tr>
                    <td>{{ ucfirst(\Carbon\Carbon::parse($mes . '-01')->translatedFormat('F')) }}</td>
                    <td>{{ $datos['asistencias'] }}</td>
                    <td>{{ $datos['horas'] }} horas {{ $datos['minutos'] }} minutos</td>
                    <td>{{ $datos['estados']['Presente'] }}</td>
                    <td>{{ $datos['estados']['Ausente Justificado'] }}</td>
                    <td>{{ $datos['estados']['Ausente Injustificado'] }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="6"> Se transcurrió un total de <strong>{{ $totalGeneral }}</strong> en asistencia
                    durante el año.</th>
            </tr>
        </tbody>
    </table>


    <hr>

    <div class="content">
        @if ($observaciones->isNotEmpty())
            <table class="arreglo">
                <thead>
                    <tr>
                        <th colspan="3">Observaciones destacadas durante el año</th>
                    </tr>
                    <tr>
                        <th class="numero">No</th>
                        <th class="fecha">Fecha</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach ($observaciones as $obs)
                        <tr>
                            <td class="numero">{{ ++$i }}</td>
                            <td class="fecha"> {{ \Carbon\Carbon::parse($obs->Fecha)->format('d/m/Y') }}</td>
                            <td class="observacion">{{ $obs->Observacion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <hr>

    <div class="content">
        <table class="arreglo">
            <thead>
                <tr>
                    <th colspan="6">Asistencias detalladas del año</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Registrado por</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Duración</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach ($infante->asistencias as $asistencia)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>
                            @if ($asistencia->usuario)
                                {{ explode(' ', $asistencia->usuario->Nombre)[0] }}
                                {{ explode(' ', $asistencia->usuario->Apellido)[0] }}
                            @else
                                No registrado
                            @endif
                        </td>
                        <td>{{ $asistencia->Estado }}</td>
                        <td>{{ \Carbon\Carbon::parse($asistencia->Fecha)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($asistencia->Hora_Ingreso)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($asistencia->Hora_Salida)->format('H:i') }}</td>
                        <td>{{ $asistencia->duracion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>
