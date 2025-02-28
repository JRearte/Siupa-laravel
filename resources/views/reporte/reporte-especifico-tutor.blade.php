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
        <h2 class="titulo">Reporte de {{ $tutor->Nombre }} {{ $tutor->Apellido }}</h2>
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
            El {{ strtolower($tutor->Tipo_tutor) }} <strong>{{ $tutor->Nombre }} {{ $tutor->Apellido }}</strong>,
            domiciliado en la localidad de {{ $tutor->domicilio->Localidad }}, barrio {{ $tutor->domicilio->Barrio }},
            calle {{ $tutor->domicilio->Calle }}, casa {{ $tutor->domicilio->Numero }}, fue dado de alta en el sistema
            <strong>SIUpa</strong> el día {{ $tutor->created_at->translatedFormat('d \d\e F \d\e Y') }}, con el
            propósito
            de inscribir a
            @if ($tutor->infantes->count() == 1)
                @php
                    $infante = $tutor->infantes->first();
                    $sufijo = $infante->Genero === 'Masculino' ? 'o' : 'a';
                @endphp
                su hij{{ $sufijo }} <strong>{{ $infante->Nombre }} {{ $infante->Apellido }}</strong>
            @else
                sus hijos/as:
                @foreach ($tutor->infantes as $infante)
                    <strong>{{ $infante->Nombre }} {{ $infante->Apellido }}</strong>
                    @if (!$loop->last)
                        y
                    @endif
                @endforeach

            @endif
            en el
            <strong>Jardín Maternal UPA</strong> para el desarrollo de su trayectoria educativa.
        </p>

        <p class="formato">
            Como <strong>{{ strtolower($tutor->Tipo_tutor) }}</strong>, su compromiso con la institución implica
            @if (strtolower($tutor->Tipo_tutor) === 'trabajador')
                el cumplimiento de los pagos correspondientes a las cuotas mensuales, habiéndose recaudado un total de 
                ${{ number_format($totalCuotasPagadas, 2, ',', '.') }} por concepto de 
                {{ $tutor->trabajador->cuotas->count() }} cuotas pagadas durante el año.
            
            @else
                mantener al menos el 50% de las asignaturas en condición de regularidad o finalización para conservar su
                beca.
                Hasta la fecha {{ now()->translatedFormat('d \d\e F \d\e Y') }}, ha alcanzado un cumplimiento del
                <strong>{{ $porcentaje }}%</strong> de un total de {{ $totalAsignaturas }} asignaturas
                comprometidas.
            @endif
        </p>


        <p>
            A continuación, se detalla la información relevante sobre la composición familiar del infante.
        </p>
    </div>

    <table class="arreglo">
        <thead>
            <tr>
                <th colspan="4">Composición familiar del infante</th>
            </tr>
            <tr>
                <th>Vínculo</th>
                <th>Nombre completo</th>
                <th>Fecha de Nacimiento</th>
                <th>Documento</th>
            </tr>
        </thead>
        <tbody>
            {{-- Fila del Tutor --}}
            <tr>
                <td>Tutor</td>
                <td>{{ $tutor->Nombre }} {{ $tutor->Apellido }}</td>
                <td>{{ $tutor->Fecha_de_nacimiento ? \Carbon\Carbon::parse($tutor->Fecha_de_nacimiento)->format('d/m/Y') : 'N/A' }}
                </td>
                <td>{{ $tutor->Numero_documento }}</td>
            </tr>

            {{-- Filas de Infantes --}}
            @foreach ($tutor->infantes as $infante)
                <tr>
                    <td>Infante</td>
                    <td>{{ $infante->Nombre }} {{ $infante->Apellido }}</td>
                    <td>{{ $infante->Fecha_de_nacimiento ? \Carbon\Carbon::parse($infante->Fecha_de_nacimiento)->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td>{{ $infante->Numero_documento }}</td>
                </tr>

                {{-- Filas de Familiares de cada Infante --}}
                @foreach ($infante->familiares as $familiar)
                    <tr>
                        <td>{{ $familiar->Vinculo }}</td>
                        <td>{{ $familiar->Nombre }} {{ $familiar->Apellido }}</td>
                        <td>{{ $familiar->Fecha_de_nacimiento ? \Carbon\Carbon::parse($familiar->Fecha_de_nacimiento)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td>{{ $familiar->Numero_documento }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>


</body>

</html>
