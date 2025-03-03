<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Sala</title>
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

        .columna{
            width: 22%;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('imagen/logo.png') }}" alt="logo" class="imagen">
        <h2 class="titulo">Reporte de la Sala {{ $sala->Nombre }}</h2>
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

    <p class="formato">
        A lo largo del año {{ date('Y') }}, los usuarios con los roles de <strong>Coordinador</strong> y
        <strong>Maestro</strong> han desempeñado un papel fundamental en el cuidado y educación de los infantes,
        supervisando su bienestar y registrando sus asistencias.
    </p>
    <p class="formato">
        A continuación, se presenta el listado de los usuarios que han participado activamente en la sala
        <strong>{{ $sala->Nombre }}</strong>, contribuyendo con su compromiso y dedicación.
    </p>

    <ul>
        @foreach ($usuariosPorcentaje as $usuario)
            <li class="lista">
                <strong>{{ $usuario['Nombre'] }} {{ $usuario['Apellido'] }}</strong>, en su rol de
                {{ $usuario['Categoria'] }}, registró el {{ $usuario['Porcentaje'] }}% de las asistencias.
            </li>
        @endforeach
    </ul>

    <!-- Tabla de Infantes -->
    <table class="arreglo">
        <thead>
            <tr>
                <th colspan="5">Infantes en la Sala</th>
            </tr>
            <tr>
                <th class="numero">No</th>
                <th>Nombre completo</th>
                <th>Categoria</th>
                <th>Fecha de asignación</th>
                <th>Habilitado</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @foreach ($infantes as $infante)
                <tr>
                    <td class="numero">{{ ++$i }}</td>
                    <td>{{ $infante->Nombre }} {{ $infante->Apellido }}</td>
                    <td>{{ $infante->Categoria }}</td>
                    <td>{{ ucfirst(\Carbon\Carbon::parse($infante->Fecha_de_asignacion)->translatedFormat('d F Y')) }}
                    </td>
                    <td>{{ $infante->Habilitado ? 'Habilitado' : 'Deshabilitado' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen de Asistencias por Mes -->
    <table class="arreglo">
        <thead>
            <tr>
                <th colspan="5">Resumen de Asistencias por Mes</th>
            </tr>
            <tr>
                <th>Mes</th>
                <th>Total de Asistencias</th>
                <th>Presente</th>
                <th>Ausente Justificado</th>
                <th>Ausente Injustificado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asistenciasPorMes as $mes => $datos)
                <tr>
                    <td >{{ ucfirst(\Carbon\Carbon::createFromFormat('Y-m', $mes)->locale('es')->translatedFormat('F')) }}
                    </td>
                    <td class="columna">{{ $datos['total'] }}</td>
                    <td class="columna">{{ $datos['Presente'] }}</td>
                    <td class="columna">{{ $datos['Ausente Justificado'] }}</td>
                    <td class="columna">{{ $datos['Ausente Injustificado'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <th colspan="5">Total de asistencias en la sala: <strong>{{ $totalAsistencias }}</strong></th>
        </tr>
    </table>
</body>

</html>
