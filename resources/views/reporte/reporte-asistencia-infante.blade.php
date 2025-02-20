<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Asistencias del Infante</title>
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

        .numero,
        .contador {
            text-align: center !important;
            font-weight: bold;
            width: 35px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('imagen/logo.png') }}" alt="logo" class="imagen">
        <h2 class="titulo">Reporte de Asistencias</h2>
        <p class="subtitulo">
            Infante: {{ $infante->Nombre }} {{ $infante->Apellido }} | Sala: {{ $infante->sala->Nombre }}
        </p>
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


    <table class="arreglo">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Horas Cumplidas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($horasPorMes as $mes => $horas)
                <tr>
                    <td>{{ ucfirst(\Carbon\Carbon::parse($mes . '-01')->translatedFormat('F')) }}</td>
                    <td>{{ $horas['horas'] }} horas {{ $horas['minutos'] }} minutos</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Total de horas cumplidas: </strong> </td>
                <td style="border-left: none">{{ $totalGeneral }}</td>
            </tr>
        </tbody>
    </table>




    <div class="content">
        <table class="arreglo">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Registrado por</th>
                    <th>Fecha</th>
                    <th>Hora Ingreso</th>
                    <th>Hora Salida</th>
                    <th>Duración</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach ($infante->asistencias as $asistencia)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>
                            {{ explode(' ', $asistencia->usuario->Nombre)[0] }}
                            {{ explode(' ', $asistencia->usuario->Apellido)[0] }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($asistencia->Fecha)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($asistencia->Hora_Ingreso)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($asistencia->Hora_Salida)->format('H:i') }}</td>
                        <td>{{ $asistencia->duracion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
