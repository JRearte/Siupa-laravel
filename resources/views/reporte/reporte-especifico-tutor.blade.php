<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Tutor</title>
    <style>
        @page {
            margin: 2.5cm 1.5cm 1.5cm 1.5cm;
        }

        /* ========== ENCABEZADO Y PIE DE PÁGINA ========== */
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

        /* ========== TABLAS ========== */
        .arreglo {
            width: 400px;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 5px;
            position: relative;
            left: 120px;
            top: 0.5cm;
            margin-bottom: 30px;
        }

        .arreglo th {
            width: 200px;
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

        .lista {
            text-align: justify;
            text-justify: inter-word;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('imagen/logo.png') }}" alt="logo" class="imagen">
        <h2 class="titulo">Reporte de {{ $tutor?->Nombre }} {{ $tutor?->Apellido }}</h2>
        <p class="subtitulo"> Sistema de información UPA </p>
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

    <div class="introduccion">
        <p class="formato">
            @php
                $tipoTutor = strtolower($tutor?->Tipo_tutor ?? 'Alumno');
                $generoTutor = strtolower($tutor?->Genero ?? 'Masculino');

                $tipoTutorFrase = match ([$tipoTutor, $generoTutor]) {
                    ['alumno', 'femenino'] => 'La alumna',
                    ['alumno', 'masculino'] => 'El alumno',
                    ['trabajador', 'femenino'] => 'La trabajadora',
                    ['trabajador', 'masculino'] => 'El trabajador',
                    default => 'El/La tutor/a',
                };
            @endphp

            {{ $tipoTutorFrase }} <strong>{{ $tutor?->Nombre }} {{ $tutor?->Apellido }}</strong>
            ({{ $tutor?->Tipo_documento }} {{ $tutor?->Numero_documento }}),
            domiciliado/a en la localidad de {{ $tutor?->domicilio?->Localidad }},
            barrio {{ $tutor?->domicilio?->Barrio }}, calle {{ $tutor?->domicilio?->Calle }},
            casa {{ $tutor?->domicilio?->Numero }}, fue dado/a de alta en el sistema <strong>SIUpa</strong> el día
            {{ $tutor?->created_at?->translatedFormat('d \d\e F \d\e Y') }} con el propósito de inscribir a

            @if ($tutor?->infantes?->count() == 1)
                @php
                    $infante = $tutor?->infantes?->first();
                    $sufijoInfante = $infante?->Genero === 'Masculino' ? 'o' : 'a';
                @endphp
                su hij{{ $sufijoInfante }} <strong>{{ $infante?->Nombre }} {{ $infante?->Apellido }}</strong>,
            @else
                sus hijos/as:
                @foreach ($tutor?->infantes as $index => $infante)
                    <strong>{{ $infante?->Nombre }} {{ $infante?->Apellido }}</strong>
                    @if ($index < $tutor?->infantes?->count() - 2)
                        ,
                    @elseif ($index == $tutor?->infantes?->count() - 2)
                        y
                    @endif
                @endforeach
            @endif
            en el <strong>Jardín Maternal UPA</strong> para el desarrollo de su trayectoria educativa.
        </p>

        <p class="formato">
            Como <strong>{{ strtolower($tutor?->Tipo_tutor) }}</strong>, su compromiso con la institución implica
            @if ($tipoTutor === 'trabajador')
                el cumplimiento de los pagos correspondientes a las cuotas mensuales. Hasta la fecha
                {{ now()->translatedFormat('d \d\e F \d\e Y') }}, ha realizado
                un total de {{ $tutor?->trabajador?->cuotas?->count() ?? 0 }} pagos, sumando
                <strong>${{ number_format($totalCuotasPagadas ?? 0, 2, ',', '.') }}</strong>.


                @if ($tutor?->trabajador?->cuotas->isNotEmpty())
                    <table class="arreglo">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tutor->trabajador->cuotas as $cuota)
                                <tr>
                                    <td>{{ $cuota->Fecha?->translatedFormat('d F Y') ?? 'N/A' }}</td>
                                    <td>${{ number_format($cuota->Valor, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="2">Total: ${{ number_format($totalCuotasPagadas ?? 0, 2, ',', '.') }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p class="formato"><em>No hay cuotas registradas hasta el momento.</em></p>
                @endif
            @else
                mantener al menos el 50% de las asignaturas cursadas en la carrera de
                <strong>{{ $tutor?->carrera?->Nombre }}</strong>
                en condición de regularidad o finalización para conservar su beca.
                Hasta la fecha {{ now()->translatedFormat('d \d\e F \d\e Y') }}, ha logrado un cumplimiento del
                <strong>{{ $porcentaje ?? 0 }}%</strong> sobre un total de {{ $totalAsignaturas ?? 0 }} asignaturas.

                @if ($tipoTutor === 'alumno' && $tutor?->carrera?->asignaturas?->isNotEmpty())
                    <p class="formato">Estas asignaturas son:</p>
                    <ul class="asignaturas">
                        @foreach ($tutor?->carrera?->asignaturas as $asignatura)
                            <li>
                                <strong>{{ $asignatura?->Codigo }} | {{ $asignatura?->Nombre }}</strong>
                                en estado <span class="condicion">{{ strtolower($asignatura?->Condicion) }}</span>,
                                con una calificación de <strong>{{ $asignatura?->Calificacion ?? 'N/A' }}</strong>.
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        </p>

        @if ($tutor?->telefonos?->isNotEmpty() || $tutor?->correos?->isNotEmpty())
            <p class="formato">
                Para comunicarse con el tutor/a, se dispone de los siguientes medios:
            </p>
            <ul>
                @if ($tutor?->telefonos?->isNotEmpty())
                    <li><strong>Teléfono:</strong>
                        {{ $tutor?->telefonos?->pluck('Numero')?->join(' | ') }}
                    </li>
                @endif
                @if ($tutor?->correos?->isNotEmpty())
                    <li><strong>Correo:</strong>
                        {{ $tutor?->correos?->pluck('Mail')?->join(' | ') }}
                    </li>
                @endif
            </ul>
        @endif
    </div>




    @foreach ($tutor->infantes as $infante)
        <p style="text-align: center"><strong>Información del Infante</strong></p>
        <p class="formato">
            <strong>{{ $infante?->Nombre }} {{ $infante?->Apellido }}</strong>,
            nacido el {{ $infante?->Fecha_de_nacimiento?->translatedFormat('d \d\e F \d\e Y') }}, actualmente con
            {{ $infante?->edad == 1 ? $infante?->edad . ' año' : $infante?->edad .' años' }},
            @if ($infante?->familiares?->isNotEmpty())
                vive junto a {{ $infante?->familiares?->count() }}
                {{ $infante?->familiares?->count() <= 1 ? 'familiar que lo acompaña en su hogar. Este es:' : 'familiares que lo acompañan en su hogar. Estos son: ' }}
        </p>

        <ul>
            @foreach ($infante?->familiares as $familiar)
                <li>
                    Su <strong>{{ strtolower($familiar?->Vinculo) }}</strong>,
                    {{ $familiar?->Nombre }} {{ $familiar?->Apellido }},
                    de {{ $familiar?->edad }} años.
                </li>
            @endforeach
        </ul>
    @endif

    @if ($infante?->medicos?->isNotEmpty())
        <p class="formato">
            Se encuentran registrados los siguientes datos médicos:
        </p>
        <ul>
            @foreach ($infante?->medicos as $medico)
                <li><strong>{{ $medico?->Tipo }}:</strong> {{ $medico?->Nombre }}</li>
            @endforeach
        </ul>
    @endif
    @endforeach

</body>

</html>
