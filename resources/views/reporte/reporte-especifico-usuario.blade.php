<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Usuario Especifico</title>
    <style>
        @page {
            size: A4;
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


        /* ========== TABLA DE HISTORIAL ========== */
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
            text-align: left;
            font-weight: bold;
        }

        .arreglo td {
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

        .formato {
            text-align: justify;
            text-justify: inter-word;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('imagen/logo.png') }}" alt="logo" class="imagen">
        <h2 class="titulo">Reporte de Usuario </h2>
        <p class="subtitulo">Legajo: {{ $usuario->Legajo }}</p>

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

    <div class="content">

        <div class="reporte-container">
            <p class="formato">
                El usuario <strong>{{ $usuario->Nombre }} {{ $usuario->Apellido }}</strong>, quien desempeña el rol de
                <strong>{{ $usuario->Categoria }}</strong> fue registrado en el sistema
                SIUpa el dia
                <strong>{{ $usuario->created_at->translatedFormat('d F Y') }}</strong>, iniciando su actividad en la
                plataforma.
                Desde entonces, ha realizado un total de
                <strong>{{ number_format($cantidadHistorial, 0, ',', '.') }}</strong> acciones,
                lo que representa un <strong>{{ number_format($porcentajeHistorial, 2, ',', '.') }}%</strong> de todas
                las actividades registradas en el sistema.
            </p>

            @if ($cantidadHistorial > 0)
                <p class="formato">
                    Su primera acción fue registrada el
                    <strong>{{ $historiales->first()->created_at->translatedFormat('d F Y \a \l\a\s H:i') }}</strong>,
                    mientras que su última actividad tuvo lugar el
                    <strong>{{ $historiales->last()->created_at->translatedFormat('d F Y \a \l\a\s H:i') }}</strong>.
                </p>
            @else
                <p class="formato">
                    Hasta la fecha, el usuario no ha realizado ninguna acción registrada en el sistema.
                </p>
            @endif
        </div>


        <!-- Tabla de historial -->
        <table class="arreglo">
            <thead>
                <tr>
                    <th class="numero">No</th>
                    <th>Historial de acciones realizadas el año {{ $usuario->created_at->format('Y') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach ($historiales as $historial)
                    <tr>
                        <td class="contador">{{ ++$i }}</td>
                        <td>{{ $historial->detalles }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
