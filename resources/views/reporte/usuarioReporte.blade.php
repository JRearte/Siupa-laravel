<!-- resources/views/reporte/usuarioReporte.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Usuarios</title>
    <style>
        @page {margin: 2.5cm 1.5cm 1.5cm 1.5cm;}
        header {position: fixed; top: -2.5cm; left: -1.5cm; width: 120%; height: 2.5cm; text-align: center; background: #CDD6CF; } 
        header .titulo { position: relative; margin: 0; top:20px;} 
        header .subtitulo { position: relative; top: 10px;}
        header .imagen { width: 9%; height: 100%; position: absolute; left: 1.5cm; top: 50%; transform: translateY(-50%); } 

        

        footer {position: fixed; bottom: -1.5cm; left: -1.5cm; width: 120%; height: 1.5cm; font-size: 15px; background: #CDD6CF; }
        footer .fecha {position: relative; text-align: center; left: 80%; top: 30%;}
        .numero { width: 0.2cm; text-align: center;}
        .contador { width: 0.2cm; text-align:  center;}
        body { font-family: Arial, sans-serif;}
        table { width: 100%; border-collapse: collapse; position: relative; top: 0.5cm; bottom: 2cm;}
        th, td { width: 16%; border: 1px solid black; padding: 8px; text-align: center;}
        th { background-color: #f2f2f2; }
        .espacio { page-break-after: always; visibility: hidden; border-top: 1px solid black;}
        .borde {border-left: none; border-right: none;}
        

    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('imagen/logo.png') }}" alt="logo" class = "imagen">
       
        <h2 class="titulo"> Reporte de usuarios </h2> 
        <p class="subtitulo">Sistema de información upa</p>
    </header>
    <footer>
        <div>
        <span class="fecha">Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
        </div>
            <!-- Script para contar páginas -->
            <script type="text/php">
            if (isset($pdf)) {
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 10;
                $pageText = "Página $PAGE_NUM";
                $y = 815; // Ajusta la posición vertical según sea necesario
                $x = 260; // Ajusta la posición horizontal según sea necesario
                $pdf->text($x, $y, $pageText, $font, $size);
            }
        </script>
    </footer>
    <div class="content">
    
        <table>
            <thead>
                <tr>
                    <th class = 'numero'>No</th>
                    <th>Legajo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td class = 'contador'>{{ ++$i }}</td>
                        <td>{{ $usuario->Legajo }}</td>
                        <td>{{ $usuario->Nombre }}</td>
                        <td>{{ $usuario->Apellido }}</td>
                        <td>{{ $usuario->Categoria }}</td>
                    </tr>
                    @if ($i % 24 == 0 && $i != count($usuarios))
                    <tr>
                        <td colspan="5" class="borde"></td>
                    </tr>
                        <tr class="espacio">
                            <td colspan="5" ></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
