<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Usuarios</title>
    <style>
        @page {
            size: A4;
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
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
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
        <h2 class="titulo"> Reporte general de los usuarios </h2>
        <p class="subtitulo">Sistema de información UPA</p>
    </header>
    <footer>
        <div>
            <span class="fecha">Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
        </div>
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
    </footer>

    <div class="content">


        <div class="reporte-container">
            <p>
                En el año <strong>{{ now()->year }}</strong>, el sistema <strong>SUIpa</strong> contó con la participación de 
                <strong>{{ number_format($total, 0, ',', '.') }}</strong> usuarios, distribuidos en cuatro roles:
            </p>
            <ul>
                <li><strong>Bienestar</strong>: gestiona todas las funciones, excepto las asistencias.</li>
                <li><strong>Coordinador</strong>: responsable de administrar y supervisar las asistencias.</li>
                <li><strong>Maestro</strong>: con permiso exclusivo para registrar asistencias.</li>
                <li><strong>Invitado</strong>: limitado únicamente a la visualización de información básica del sistema.</li>
            </ul>
            
            <p>De estos usuarios:</p>
            <ul>
                <li>
                    <strong>{{ number_format($bienestar, 0, ',', '.') }}</strong> pertenecen a la categoría 
                    <strong>Bienestar</strong>, representando el <strong>{{ $porcentajeBienestar }}%</strong>.
                </li>
                <li>
                    <strong>{{ number_format($coordinador, 0, ',', '.') }}</strong> son <strong>Coordinadores</strong>, 
                    representando el <strong>{{ $porcentajeCoordinador }}%</strong>.
                </li>
                <li>
                    <strong>{{ number_format($maestro, 0, ',', '.') }}</strong> son <strong>Maestros</strong>, 
                    representando el <strong>{{ $porcentajeMaestro }}%</strong>.
                </li>
                <li>
                    <strong>{{ number_format($invitado, 0, ',', '.') }}</strong> son <strong>Invitados</strong>, 
                    representando el <strong>{{ $porcentajeInvitado }}%</strong>.
                </li>
            </ul>
        </div>
        
        <p>A continuación, se presentarán los usuarios en orden alfabético por su apellido, destacando su rol:</p>
        

        <!-- Tabla de usuarios -->
        <table class="arreglo">
            <thead>
                <tr>
                    <th class='numero'>No</th>
                    <th>Legajo</th>
                    <th>Nombre Completo</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td class='contador'>{{ ++$i }}</td>
                        <td>{{ $usuario->Legajo }}</td>
                        <td>{{ $usuario->Nombre }} {{ $usuario->Apellido }}</td>
                        <td>{{ $usuario->Categoria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
