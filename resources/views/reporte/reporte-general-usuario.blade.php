<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Usuarios</title>
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
        <!-- Tabla de categorías arriba -->
        <table class="arreglo">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bienestar</td>
                    <td>{{ $bienestar }} de {{ $total }}</td>
                    <td>{{ number_format($porcentajeBienestar, 2) }}%</td>
                </tr>
                <tr>
                    <td>Coordinador</td>
                    <td>{{ $coordinador }} de {{ $total }}</td>
                    <td>{{ number_format($porcentajeCoordinador, 2) }}%</td>
                </tr>
                <tr>
                    <td>Maestro</td>
                    <td>{{ $maestro }} de {{ $total }}</td>
                    <td>{{ number_format($porcentajeMaestro, 2) }}%</td>
                </tr>
                <tr>
                    <td>Invitado</td>
                    <td>{{ $invitado }} de {{ $total }}</td>
                    <td>{{ number_format($porcentajeInvitado, 2) }}%</td>
                </tr>
            </tbody>
        </table>

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
